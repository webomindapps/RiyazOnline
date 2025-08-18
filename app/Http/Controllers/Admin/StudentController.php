<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewStudentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Imports\StudentImport;
use App\Mail\BulkMail;
use App\Mail\RenewMail;
use App\Models\AdminMail;
use App\Models\Country;
use App\Models\Course;
use App\Models\EmailTemplate;
use App\Models\State;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function __construct(public StudentDetail $student) {}

    public function index()
    {
        $searchColumns = ['id', 'f_name', 'l_name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;
        $fromDt = request()->from_date;
        $toDt = request()->to_date;

        $query = $this->student->query();
        $query->where('status', 1);

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                $q->orWhereRaw("CONCAT(f_name, ' ', l_name) LIKE ?", ["%{$search}%"]);
            });

        if ($fromDt && $toDt) {
            $query->whereBetween('date', [$fromDt, $toDt]);
        }
        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $students = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        $emailtemplates = EmailTemplate::orderBy('priority', 'asc')->get();
        return view('admin.students.index', compact('students', 'emailtemplates'));
    }
    public function create()
    {
        $courses = Course::where('status', 1)->get();
        $countries = Country::all();
        return view('admin.students.create', compact('courses', 'countries'));
    }
    public function store(StudentRequest $request)
    {
        $course = Course::find($request->course);
        $data = $request->validated();
        DB::beginTransaction();
        try {
            if ($request->has('photo') && $request->file('photo')) {
                $path = $request->file('photo')->store('photos', 'public');
                $data['profile_picture'] = $path;
            }
            $status = 1;
            if ($data['payment_type'] == 1) {
                $status = 2;
            }
            $data['status'] = $status;
            $data['date'] = date('Y-m-d');
            $student = $this->student->create($data);
            $invoice_no = $this->generateInvoiceNo();
            $convenance = 0;
            $gst_amount = 0;
            $grand_total = $course->new_student_fees;
            $fees = $course->new_student_fees;
            StudentCourseDetail::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'course_name' => $course->course_name,
                "invoice_no" => $invoice_no[0],
                "financial_year" => $invoice_no[1],
                'type' => $data['payment_type'],
                'convenience_fees' => $convenance,
                'gst_amount' => $gst_amount,
                'grand_total' => $grand_total,
                'amount' => $fees,
                'due_date' => Carbon::parse($data['latest_paid_date'])->addMonth()->format('Y-m-d'),
                'paid_date' => $data['latest_paid_date'],
                'teacher' => "1",
                'manual' => "1",
                'penalty_amount' => 0,
                'pdf_link' => 1,
                'method' => $data['payment_type'],
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        return redirect()->route('admin.all.students')->with('success', 'Student added successfully');
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

    public function edit($id)
    {
        $student = $this->student->find($id);
        $courses = Course::where('status', 1)->get();
        $countries = Country::all();
        $state = State::where('id', $student->state_id)->first();
        return view('admin.students.edit', compact('student', 'courses', 'countries', 'state'));
    }
    public function update(StudentRequest $request, $id)
    {
        $data = $request->validated();
        $student = $this->student->find($id);
        if ($request->file('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['profile_picture'] = $path;
        }
        $student->update($data);
        if ($data['date_joining']) {
            $student->update(['status' => 2]);
        }
        if ($data['due_date']) {
            $student->studentcourse->update([
                'due_date' => $data['due_date'],
            ]);
        }
        if ($request->course) {
            $student->studentcourse->update([
                'course_id' => $request->course,
            ]);
        }
        return redirect()->route('admin.all.students')->with('success', 'Student updated successfully');
    }
    public function AllStudent()
    {
        $searchColumns = ['id', 'f_name', 'l_name', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->student->query();
        $query->where('status', 2);
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                $q->orWhereRaw("CONCAT(f_name, ' ', l_name) LIKE ?", ["%{$search}%"]);
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $students = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        $emailtemplates = EmailTemplate::orderBy('priority', 'asc')->get();
        return view('admin.students.all_students', compact('students', 'emailtemplates'));
    }

    public function disabledStudents()
    {
        $searchColumns = ['id', 'name', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->student->query();
        $query->where('status', 3);

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $students = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.students.disabled', compact('students'));
    }
    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $student = $this->student->find($id);
        $date = date("Y-m-d");
        $value = $request->value;
        $remark = $request->remark;

        $updateData = [
            "status" => $value,
            "attrition_date" => $date,
        ];

        if (!empty($remark)) {
            $updateData['comment'] = $remark;
        }

        $student->update($updateData);

        return ['success', 'Student status changed successfully'];
    }
    public function addJoinDate(Request $request)
    {
        $student = $this->student->find($request->id);
        $student->update([
            'status' => 2,
            'date_joining' => $request->join_date,
        ]);
        $studentCourse = StudentCourseDetail::where('student_id', $student->id)->where('type', 1)->first();
        $paid_date = $studentCourse->paid_date;
        $date = $request->join_date;
        if ($paid_date) {
            $studentCourse->update([
                'date' => $date,
                'paid_date' => $date,
                'due_date' => Carbon::parse($date)->addMonth()->format('Y-m-d')
            ]);
        } else {
            $studentCourse->update([
                'date' => $date,
                'due_date' => Carbon::parse($date)->addMonth()->format('Y-m-d')
            ]);
        }
        $email = $student->email;
        $name = $student->email;
        $data = [
            'date' => date("d-m-Y", strtotime($date))
        ];
        // mail functionality
        $this->sendSMS($date);
        return ['status' => 'success'];
    }

    public function details($id)
    {
        $student = $this->student->with('studentcourses')->find($id);
        if ($student->status == 1) {
            return [
                'html' => view('admin.students.new-student-detail-modal', compact('student'))->render()
            ];
        } else {
            return [
                'html' => view('admin.students.existing-student-detail-modal', compact('student'))->render()
            ];
        }
    }
    public function viewInvoice($id)
    {
        $studentCourse = StudentCourseDetail::with('student', 'course')->find($id);
        $pdf = PDF::loadView('admin.students.invoice', compact('studentCourse'));
        return view('admin.students.invoice', compact('studentCourse'));
    }
    public function newStudentExport(Request $request)
    {
        $searchColumns = ['id', 'name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $fromDt = request()->from_date;
        $toDt = request()->to_date;

        $query = $this->student->query();
        $query->where('status', 1);

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        if ($fromDt && $toDt) {
            $query->whereBetween('date', [$fromDt, $toDt]);
        }
        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $students = $query->get();
        return Excel::download(new NewStudentExport($students), 'NewStudents.xlsx');
    }
    public function studentImport(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $import = new StudentImport();
                Excel::import($import, $file);
                $error = '';
                foreach ($import->failures() as $failure) {
                    $failure->row();
                    $failure->attribute();
                    $failure->errors();
                    $failure->values();
                    $error .= 'Row no:-' . $failure->row() . ', Column:-' . $failure->attribute() . ', Error:-' . $failure->errors()[0] . '<br>';
                }
                return redirect()->back()->with('success', 'Students imported successfully');
            } catch (Exception $e) {
                dd($e);
                return redirect()->back()->withErrors(['error' => 'Failed to import students: ' . $e->getMessage()]);
            }
        }
        return redirect()->back()->withErrors(['error' => 'No file uploaded']);
    }
    public function bulkMail(Request $request)
    {
        // $studentMails = $this->student->whereIn('id', $request->student)->pluck('email');
        $studentMails = $this->student->whereIn('id', $request->student)->get();
        $template = EmailTemplate::find($request->template_id);
        $content = $request->content;
        // dd($studentMails,$request->all());
        $emails = AdminMail::where('status', 1)->pluck('email')->toArray();
        foreach ($studentMails as $student) {
            Mail::to($student->email)->cc($emails)->send(new BulkMail($content, $template->title, $student));
        }
        // Mail::to($studentMails)->send(new BulkMail($content, $template->title,$student));
        return ['success' => 'Mail sent successfully'];
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

    public function sendSMS($date)
    {
        $userId = 'riyaazobiz';
        $password = 'uebj8002UE';
        $senderId = 'RYZONL';
        $phoneNumber = '9668122651';
        $message = "Dear Dhruba, Greetings from RiyaazOnline music classes. Kindly note, that your fees due date is on " . date('d', strtotime($date)) . " of every month. Kindly make the payment on or before the due date to continue your lessons smoothly. Please ignore if already paid. Thank you";
        $entityId = '1701172914234060146';
        $templateId = '1707173821059462047';

        $response = $this->sendSingleSms($userId, $password, $senderId, $phoneNumber, $message, $entityId, $templateId);
        // dd($response);
    }
    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = StudentDetail::selectRaw("CONCAT(f_name, ' ', l_name) AS full_name")
            ->whereRaw("CONCAT(f_name, ' ', l_name) LIKE ?", ["%{$query}%"])
            ->where('status','!=',3)
            ->pluck('full_name');
        return response()->json($filterResult);
    }

    public function renew()
    {
        return view('admin.students.renew');
    }
    public function getDetailsByRoll($id)
    {
        $student = $this->student->with('studentcourse','course')->find($id);

        if ($student) {
            return response()->json([
                'status' => 'success',
                'data' => $student
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found'
            ]);
        }
    }
    public function renewStore(Request $request)
    {
        $data = $request->validate([
            'roll_no' => 'required',
            'course_id' => 'required|exists:courses,id',
            'due_date' => 'required|date',
            'paid_date' => 'required|date',
            'amount' => 'required|numeric',
            'convenience_fees' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
        ]);

        $student = $this->student->find($data['roll_no']);
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found']);
        }

        $course = Course::find($data['course_id']);
        if (!$course) {
            return redirect()->back()->withErrors(['error' => 'Course not found']);
        }

        DB::beginTransaction();
        try {
            $invoice_no = $this->generateInvoiceNo();
            $studentcourse=StudentCourseDetail::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'course_name' => $course->course_name,
                "invoice_no" => $invoice_no[0],
                "financial_year" => $invoice_no[1],
                'type' => 1,
                'convenience_fees' => $data['convenience_fees'] ?? 0,
                'gst_amount' => 0, // Assuming no GST for renewals
                'grand_total' => $data['grand_total'],
                'amount' => $data['amount'],
                'due_date' => Carbon::parse($data['due_date'])->addMonths(1)->format('Y-m-d'),
                'paid_date' => Carbon::parse($data['paid_date'])->format('Y-m-d'),
                'teacher' => "1",
                'manual' => "1",
                'penalty_amount' => 0,
                'pdf_link' => 1,
                'method' => 1, 
            ]);
            DB::commit();
            $emails=AdminMail::where('status',1)->pluck('email')->toArray();
            $emails[] = $student->email;
            Mail::to($emails)->send(new RenewMail($studentcourse));
            return redirect()->route('admin.all.students')->with('success', 'Student renewed successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to renew student: ' . $e->getMessage()]);
        }
    }

    public function updateComment(Request $request)
    {
        $id = $request->id;
        $comment = $request->comment;

        $student = $this->student->find($id);
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $student->update(['comment' => $comment]);

        return response()->json(['success' => 'Comment updated successfully']);
    }
}
