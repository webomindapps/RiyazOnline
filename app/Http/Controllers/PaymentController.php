<?php

namespace App\Http\Controllers;

use App\Mail\ExamRegistrationMail;
use App\Mail\RenewMail;
use App\Models\AdminMail;
use App\Models\ExamRegistration;
use App\Models\PaymentDetail;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use App\Models\TempStudent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function paymentInitiate(Request $request)
    {
        $student = TempStudent::find($request->temp_id);
        $key_id = env('RAZORPAY_KEY_ID');
        $secret = env('RAZORPAY_SECRET_KEY');
        $api = new Api($key_id, $secret);
        $order = $api->order->create([
            'receipt' => $request->temp_id,
            'amount' => (float) $student->grand_total * 100,
            'currency' => 'INR',
            'notes' => [
                'student_id'   => $request->temp_id,
                'paying_for'    => 1,
                'paying_for_months' => 1 . ' months',
            ]
        ]);
        $type = "new";

        return view('frontend.payment', compact('student', 'order', 'type'));
    }
    public function paymentConfirm(Request $request, $id)
    {
        $key_id = env('RAZORPAY_KEY_ID');
        $secret = env('RAZORPAY_SECRET_KEY');
        $api = new Api($key_id, $secret);
        $response = $api->payment->fetch($request->razorpay_payment_id);
        PaymentDetail::create([
            'student_id' => $id,
            'type' => 'new',
            'email' => $response->email,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_signature' => $request->razorpay_signature,
            'payment_status' => $response->status,
            'amount' => $response->amount / 100,
            'paying_for' => $response->notes?->paying_for,
        ]);
        if ($response->status == "captured") {
            return redirect()->route('student.store', $id);
        } else {
            return redirect('/')->with('error', 'Payment failed');
        }
    }
    public function renewalPaymentInitiate(Request $request)
    {
        // dd($request->all());
        $key_id = env('RAZORPAY_KEY_ID');
        $secret = env('RAZORPAY_SECRET_KEY');
        $api = new Api($key_id, $secret);
        $order = $api->order->create([
            'receipt' => $request->student_id,
            'amount' => (float) $request->total * 100,
            'currency' => 'INR',
            'notes' => [
                'student_id'   => $request->student_id,
                'paying_for'    => $request->paying_for,
                'paying_for_months' => $request->paying_for . ' months',
                'amount' => $request->amount,
                'conv_fee' => $request->conv_fee,
                'total' => $request->total,
            ]
        ]);
        $type = "existing";
        $student = StudentDetail::find($request->student_id);
        return view('frontend.payment', compact('student', 'order', 'type'));
    }
    public function renewalPaymentConfirm(Request $request, $id)
    {
        $key_id = env('RAZORPAY_KEY_ID');
        $secret = env('RAZORPAY_SECRET_KEY');
        $api = new Api($key_id, $secret);
        $response = $api->payment->fetch($request->razorpay_payment_id);
        $amount = $response->amount / 100;
        PaymentDetail::create([
            'student_id' => $id,
            'type' => 'existing',
            'email' => $response->email,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_signature' => $request->razorpay_signature,
            'payment_status' => $response->status,
            'amount' => $amount,
            'paying_for' => $response->notes?->paying_for,
        ]);
        if ($response->status == "captured") {
            DB::beginTransaction();
            try {
                $student = StudentDetail::find($id);
                $course = $student->studentcourse?->course;
                $invoice_no = $this->generateInvoiceNo();
                $studentcourse = StudentCourseDetail::create([
                    'student_id' => $id,
                    'course_id' => $course->id,
                    'course_name' => $course->course_name,
                    "invoice_no" => $invoice_no[0],
                    "financial_year" => $invoice_no[1],
                    'type' => $response->notes?->paying_for,
                    'convenience_fees' => $response->notes?->conv_fee,
                    'gst_amount' => 0,
                    'grand_total' => $response->notes?->total,
                    'amount' => $response->notes?->amount,
                    'due_date' => Carbon::parse($student->studentcourse?->due_date)->addMonths((int) ($response->notes?->paying_for ?? 1))->format('Y-m-d'),
                    'paid_date' => date("Y-m-d"),
                    'teacher' => "1",
                    'manual' => "2",
                    'penalty_amount' => 0,
                    'pdf_link' => 1,
                    'method' => 1,
                ]);
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                dd($e);
            }
            $emails = AdminMail::where('status', 1)->pluck('email')->toArray();
            $emails[] = $student->email;
            Mail::to($emails)->send(new RenewMail($studentcourse));
            return redirect()->route('home')->with('renewed', 'Student course renewed successfully. Please check your email for further details.');
        } else {
            return redirect('/')->with('error', 'Payment failed');
        }
    }
    public function generateInvoiceNo()
    {
        $prefix = "RZ";
        $month = date('m');

        // Determine financial year (e.g., 23-24)
        if ($month < 4) {
            $startYear = date('y', strtotime('-1 year'));
            $endYear = date('y');
        } else {
            $startYear = date('y');
            $endYear = date('y', strtotime('+1 year'));
        }

        $financialYear = $startYear . $endYear;

        // Pattern to match current financial year
        $pattern = "{$prefix}/{$financialYear}/%";

        // Get last invoice_no of current financial year
        $last = StudentCourseDetail::where('invoice_no', 'like', $pattern)
            ->orderByDesc('id') // assuming higher ID = latest
            ->first();

        if ($last) {
            // Extract last number from invoice_no
            $parts = explode('/', $last->invoice_no);
            $lastNumber = isset($parts[2]) ? intval($parts[2]) : 0;
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Pad number with leading zeroes (e.g. 0001)
        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $invoiceNo = "{$prefix}/{$financialYear}/{$formattedNumber}";

        return [$invoiceNo, $financialYear];
    }
    public function examPaymentInitiate(Request $request)
    {
        $key_id = env('RAZORPAY_KEY_ID');
        $secret = env('RAZORPAY_SECRET_KEY');
        $api = new Api($key_id, $secret);
        $student = StudentDetail::find($request->student_id);
        $total = $request->total;
        $order = $api->order->create([
            'receipt' => $request->student_id,
            'amount' => (float) $total * 100,
            'currency' => 'INR',
            'notes' => [
                'student_id'   => $request->student_id,
                'exam_fee' => $request->exam_fee,
                'conv_fee' => $request->conv_fee,
                'total' => $request->total,
            ]
        ]);
        return view('frontend.exam-payment', compact('order', 'student', 'total'));
    }
    public function examPaymentConfirm(Request $request, $id)
    {
        $key_id = env('RAZORPAY_KEY_ID');
        $secret = env('RAZORPAY_SECRET_KEY');
        $api = new Api($key_id, $secret);
        $response = $api->payment->fetch($request->razorpay_payment_id);
        $amount = $response->amount / 100;
        if ($response->status == "captured") {
            DB::beginTransaction();
            try {
                $student = StudentDetail::find($id);
                ExamRegistration::create([
                    'student_id' => $id,
                    'payment_date' => date('Y-m-d'),
                    'exam_fee' => $response->notes?->exam_fee,
                    'convience_fee' => $response->notes?->conv_fee,
                    'total' => $response->notes?->total,
                    'payment_status' => true
                ]);
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                dd($e);
            }
            $emails = AdminMail::where('status', 1)->pluck('email')->toArray();
            $emails[] = $student->email;
            Mail::to($emails)->send(new ExamRegistrationMail($student));
            return redirect()->route('home')->with('renewed', 'Registration Successfull Please check your mail for confirmation');
        } else {
            return redirect('/')->with('error', 'Payment failed');
        }
    }
}
