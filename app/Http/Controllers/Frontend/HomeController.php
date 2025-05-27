<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\CompletedProfile;
use App\Mail\CompleteRegisterMail;
use App\Models\Country;
use App\Models\Course;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use App\Models\TempStudent;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $countries = Country::where('status', true)->get();
        return view('frontend.new-student', compact('course', 'countries'));
    }
    public function studentCreate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10',
            'contact_no2' => 'required|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10|different:phone',
        ], ['contact_no2.required' => 'Alternate Phone number is required.', 'contact_no2.different' => 'Alternate Phone number should be differnt']);
        $tot_ses = 0;
        $course = Course::find($id);
        $course_name = $course->course_name;
        $course_price = $course->new_student_fees;
        $grand_total = $course_price;
        DB::beginTransaction();
        try {
            $order = TempStudent::create([
                "user_id" => 1,
                "name" => $request->name,
                "email" => $request->email,
                "age" => $request->age,
                "phone" => $request->phone,
                "phone_two" => $request->contact_no2,
                "course" => $course_name,
                "course_id" => $id,
                "country_id" => $request->country_id,
                "convenience_fees" => 0,
                "total_fees" => $grand_total,
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
    public function studentStore(Request $request)
    {
        $order = TempStudent::find($request->temp_id);
        if (is_null($order)) {
            return redirect()->route('home')->with('error', 'Something went wrong. Please try again.');
        }
        $course = Course::find($order->course_id);
        DB::beginTransaction();
        try {
            $student = StudentDetail::create([
                "name" => $order->name,
                "email" => $order->email,
                "age" => $order->age,
                "phone" => $order->phone,
                "phone_2" => $order->phone_two,
                "country_id" => $order->country_id,
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
                'grand_total' => $order->total_fees,
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
        return redirect()->route('home')->with('registered', 'Student registered successfully. Please check your email for further details.');
    }
    public function renewalStore(Request $request)
    {
        $course = Course::find($request->course_id);
        $course_fee = $course->old_student_fees;

        $sub_tot = $course_fee + $request->penalty;
        $student = StudentDetail::find($request->student_id);
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
                'convenience_fees' => $request->conv_fee,
                'gst_amount' => 0,
                'grand_total' => $sub_tot,
                'amount' => $request->amount,
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
        $student = StudentDetail::where('email', $request->email)->where('id', $request->roll_no)->with('studentcourse')->first();
        if ($student) {
            return response()->json(['status' => true, 'data' => $student]);
        } else {
            return response()->json(['status' => false, 'message' => 'No student found.']);
        }
    }
    public function getCourseDetails(Request $request)
    {
        $student = StudentDetail::where('id', $request->roll_no)->where('email', $request->email)->first();
        if (is_null($student)) {
            return redirect()->route('existing.student')->with('notfound', 'student not found with this roll no & email');
        }
        $studentcourse = StudentCourseDetail::with('student', 'course')->where('student_id', $request->roll_no)->orderBy('id', 'DESC')->first();
        $date1 = new DateTime($studentcourse->date);
        $date2 = new DateTime(); // defaults to "now"
        $diff = date_diff($date1, $date2);
        $day_diff = $diff->format("%R%a");
        $penalty = 0;
        if ($studentcourse->student->penalty_congestion != 1) {
            if ($day_diff >= 1 && $day_diff <= 7) {
                if ($studentcourse->student->penalty_amount == "") {
                    $penalty = 350;
                } else {
                    $penalty = $studentcourse->student->penalty_amount;
                }
            } else if ($day_diff >= 8 && $day_diff <= 14) {
                if ($studentcourse->student->penalty_amount == "") {
                    $penalty = 550;
                } else {
                    $penalty = $studentcourse->student->penalty_amount;
                }
            } else if ($day_diff >= 15 && $day_diff <= 21) {
                if ($studentcourse->student->penalty_amount == "") {
                    $penalty = 750;
                } else {
                    $penalty = $studentcourse->student->penalty_amount;
                }
            } else if ($day_diff >= 22 && $day_diff <= 28) {
                if ($studentcourse->student->penalty_amount == "") {
                    $penalty = 950;
                } else {
                    $penalty = $studentcourse->student->penalty_amount;
                }
            } else if ($day_diff >= 29) {
                if ($studentcourse->student->penalty_amount == "") {
                    $penalty = 1150;
                } else {
                    $penalty = $studentcourse->student->penalty_amount;
                }
            }
        }
        $due = $request->due ?? $studentcourse->date;
        $total = $studentcourse->course->old_student_fees + $penalty;
        $convfee = (($total) * 2.50) / 100;
        $subTotal = $total - $convfee;
        $request->session()->put('total', $total);
        $total = $request->session()->get('total');
        return view('frontend.existing-student-step2', compact('studentcourse', 'penalty', 'total', 'convfee', 'subTotal', 'due'));
    }
    public function completeRegistrationView($id)
    {
        $student = StudentDetail::find($id);
        return view('frontend.complete-registration', compact('student'));
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
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_2' => $request->phone_2,
                'student_whatsapp_no' => $request->whatsapp_no,
                'dob' => $request->dob,
                'age' => $request->age,
                'gender' => $request->gender,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'current_address' => $request->current_address,
                'permanent_address' => $request->permanent_address,
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
        Mail::to($student->email)->send(new CompletedProfile($student));
        return redirect()->route('home')->with('complete', 'Student registration completed successfully.');
    }
}
