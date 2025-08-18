<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\CompletedProfile;
use App\Mail\CompleteRegisterMail;
use App\Mail\NewRegistration;
use App\Models\AdminMail;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\State;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use App\Models\TempStudent;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::where('status', true)->get();
        return view('frontend.index', compact('courses'));
    }
    public function courseDetails($id)
    {
        $course = Course::findOrFail($id);
        $countries = Country::all();
        return view('frontend.new-student', compact('course', 'countries'));
    }
    public function studentCreate(Request $request, $id)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'age' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10',
            'contact_no2' => 'required|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10|different:phone',
        ], ['contact_no2.required' => 'Alternate Phone number is required.', 'contact_no2.different' => 'Alternate Phone number should be differnt']);
        $tot_ses = 0;
        $course = Course::find($id);
        $course_name = $course->course_name;
        $course_price = $course->new_student_fees;
        $conv_fee = 0;
        if ($request->country_id == "101") {
            $conv_fee = ($course_price * $course->conv_indian) / 100;
        } else {
            $conv_fee = ($course_price * $course->conv_foreigner) / 100;
        }
        $grand_total = $course_price + $conv_fee;
        DB::beginTransaction();
        try {
            $order = TempStudent::create([
                "user_id" => 1,
                "f_name" => $request->f_name,
                "l_name" => $request->l_name,
                "email" => $request->email,
                "age" => $request->age,
                "phone" => $request->phone,
                "phone_two" => $request->contact_no2,
                "course" => $course_name,
                "course_id" => $id,
                "country_id" => $request->country_id,
                "state_id" => $request->state_id,
                "city" => $request->city,
                "convenience_fees" => $conv_fee,
                "total_fees" => $course_price,
                "gst_amount" => 0,
                "grand_total" => $grand_total,
                "date" => date("Y-m-d"),
                "status" => 0,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
        return view('frontend.checkout', compact('course', 'order'));
    }
    public function studentStore($temp_id)
    {
        $order = TempStudent::find($temp_id);
        if (is_null($order)) {
            return redirect()->route('home')->with('error', 'Something went wrong. Please try again.');
        }
        $course = Course::find($order->course_id);
        DB::beginTransaction();
        try {
            $student = StudentDetail::create([
                "f_name" => $order->f_name,
                "l_name" => $order->l_name,
                "email" => $order->email,
                "age" => $order->age,
                "phone" => $order->phone,
                "phone_2" => $order->phone_two,
                "country_id" => $order->country_id,
                "state_id" => $order->state_id,
                "city" => $order->city,
                'status' => 1,
                'date' => date("Y-m-d"),
                'latest_paid_date' => date("Y-m-d"),
            ]);
            $invoice_no = $this->generateInvoiceNo();
            $studentcourse = StudentCourseDetail::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'course_name' => $course->course_name,
                "invoice_no" => $invoice_no[0],
                "financial_year" => $invoice_no[1],
                'type' => 1,
                'convenience_fees' => $order->convenience_fees,
                'gst_amount' => $order->gst_amount,
                'grand_total' => $order->grand_total,
                'amount' => $order->total_fees,
                'due_date' => Carbon::parse($order->date)->addMonth()->format('Y-m-d'),
                'paid_date' => date("Y-m-d"),
                'teacher' => "1",
                'manual' => "1",
                'penalty_amount' => 0,
                'pdf_link' => 1,
                'method' => 1,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        Mail::to($order->email)->send(new CompleteRegisterMail($studentcourse));
        $emails = AdminMail::where('status', 1)->pluck('email')->toArray();
        $emails[] = $student->email;
        Mail::to($emails)->send(new NewRegistration($student));
        return redirect()->route('home')->with('registered', 'Student registered successfully. Please check your email for further details.');
    }
    public function renewalStore($id)
    {
        $student = StudentDetail::find($id);
        $course = $student->studentcourse?->course;
        $course_fee = $course->old_student_fees;

        $sub_tot = $course_fee;
        $total = $sub_tot + 100; // Adding convenience fees
        $invoice_no = $this->generateInvoiceNo();
        DB::beginTransaction();
        try {
            StudentCourseDetail::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'course_name' => $course->course_name,
                "invoice_no" => $invoice_no[0],
                "financial_year" => $invoice_no[1],
                'type' => 1,
                'convenience_fees' => 100,
                'gst_amount' => 0,
                'grand_total' => $total,
                'amount' => $sub_tot,
                'due_date' => Carbon::parse($student->studentcourse?->due_date)->addMonth()->format('Y-m-d'),
                'paid_date' => date("Y-m-d"),
                'teacher' => "1",
                'manual' => "2",
                'penalty_amount' => 0,
                'pdf_link' => 1,
                'method' => 1,
            ]);
            $student->update(["penalty_congestion" => "0", "penalty_amount" => "0"]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        return redirect()->route('home')->with('renewed', 'Student course renewed successfully. Please check your email for further details.');
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
    public function existingStudent()
    {
        return view('frontend.existing-student');
    }
    public function getStudentDetails(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'roll_no' => 'required',
        ]);
        $student = StudentDetail::where('email', $request->email)->where('id', $request->roll_no)->where('status', '!=', 3)->with('studentcourse')->first();
        if ($student) {
            return response()->json(['status' => true, 'data' => $student]);
        } else {
            return response()->json(['status' => false, 'message' => 'No student found.']);
        }
    }
    public function getCourseDetails(Request $request)
    {
        $student = StudentDetail::where('id', $request->roll_no)->where('email', $request->email)->where('status', '!=', 3)->first();
        if (is_null($student)) {
            return redirect()->route('existing.student')->with('notfound', 'student not found with this roll no & email');
        }
        $studentcourse = StudentCourseDetail::with('student', 'course')->where('student_id', $request->roll_no)->orderBy('id', 'DESC')->first();
        $paying_for = 1;
        switch ($student->payment_type) {
            case 0: // Guitar
                $paying_for = 1;
                break;
            case 1: // Keyboard
                $paying_for = 3;
                break;
            case 2: // Vocal
                $paying_for = 6;
                break;
            default:
                $paying_for = 1;
        }
        $due = $request->due ?? $studentcourse->date;
        $subTotal = $studentcourse->course?->old_student_fees * $paying_for;
        if ($student->country_id == 101) {
            $covinence = ($studentcourse->course?->old_student_fees * $studentcourse->course?->conv_indian) / 100;
        } else {
            $covinence = ($studentcourse->course?->old_student_fees * $studentcourse->course?->conv_foreigner) / 100;
        }
        $convfee = $covinence * $paying_for; // Convenience fee is 100 per course
        $total = $subTotal + $convfee;
        $request->session()->put('total', $total);
        $total = $request->session()->get('total');
        return view('frontend.existing-student-step2', compact('studentcourse', 'total', 'convfee', 'subTotal', 'due', 'paying_for', 'student'));
    }
    public function completeRegistrationView($id)
    {
        $countries = Country::all();
        $student = StudentDetail::find($id);
        $state = State::where('id', $student->state_id)->first();
        return view('frontend.complete-registration', compact('student', 'countries', 'state'));
    }
    public function completeRegistration(Request $request, $id)
    {
        $student = StudentDetail::find($id);
        if (is_null($student)) {
            return redirect()->route('home')->with('error', 'Student not found.');
        }
        DB::beginTransaction();
        try {
            $path = $request->file('photo')->store('photos', 'public');
            $student->update([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_2' => $request->phone_2,
                'student_whatsapp_no' => $request->whatsapp_no,
                'dob' => $request->dob,
                'age' => $request->age,
                'gender' => $request->gender,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city' => $request->city,
                'current_address' => $request->current_address,
                'p_country_id' => $request->p_country_id,
                'p_state_id' => $request->p_state_id,
                'p_city' => $request->p_city,
                'permanent_address' => $request->permanent_address,
                'emg_contact_person' => $request->emg_contact_person,
                'emg_contact_no' => $request->emg_contact_no,
                'emg_relation' => $request->emg_relation,
                'occupation' => $request->occupation,
                'office_no' => $request->office_no,
                'office_address' => $request->office_address,
                'profile_picture' => $path,
                'reg_status' => 1,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        $emails = AdminMail::where('status', 1)->pluck('email')->toArray();
        $emails[] = $student->email;
        Mail::to($emails)->send(new CompletedProfile($student));
        return redirect()->route('home')->with('complete', 'Student registration completed successfully.');
    }

    public function sendSingleSms($userId, $password, $senderId, $phoneNumber, $message, $entityId, $templateId)
    {
        $encodedMessage = urlencode($message);
        $encodedPassword = urlencode($password);

        $response = Http::get('http://nimbusit.biz/api/SmsApi/SendSingleApi', [
            'UserID'     => $userId,
            'Password'   => $password,
            'SenderID'   => $senderId,
            'Phno'       => $phoneNumber,
            'Msg'        => $message,
            'EntityID'   => $entityId,
            'TemplateID' => $templateId,
        ]);

        return $response->body();
    }

    public function sendSMS()
    {
        $userId = 'riyaazobiz';
        $password = 'uebj8002UE';
        $senderId = 'RYZONL';
        $phoneNumber = '9668122651';
        $message = 'Dear Dhruba, Greetings from RiyaazOnline music classes. Kindly note, that your fees due date is on 15-06-2025 of every month. Kindly make the payment on or before the due date to continue your lessons smoothly. Please ignore if already paid. Thank you';
        $entityId = '1701172914234060146';
        $templateId = '1707173821059462047';

        $response = $this->sendSingleSms($userId, $password, $senderId, $phoneNumber, $message, $entityId, $templateId);
        dd($response);
    }

    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }
    public function getCities($state_id)
    {
        $states = City::where('state_id', $state_id)->get();
        return response()->json($states);
    }
    public function missingClass()
    {
        return view('frontend.missingclass');
    }
    public function examRegistrationPage()
    {
        return view('frontend.exam-form');
    }
    public function examPaymentPage(Request $request)
    {
        $student = StudentDetail::where('email', $request->email)->where('id', $request->roll_no)->where('status', '!=', 3)->first();
        if ($student) {
            if ($student->country_id == 101) {
                $convfee = (1500 * 3) / 100;
            } else {
                $convfee = (1500 * 4) / 100;
            }
            $exam_fee = 1500; // Convenience fee is 100 per course
            $total = $exam_fee + $convfee;
            return view('frontend.exam-prices', compact('student', 'exam_fee', 'convfee', 'total'));
        } else {
            return response()->json(['status' => false, 'message' => 'No student found.']);
        }
    }
}
