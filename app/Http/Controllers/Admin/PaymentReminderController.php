<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class PaymentReminderController extends Controller
{
    public function __construct(public StudentCourseDetail $studentCourse, public StudentDetail $student) {}
    public function todayPayment()
    {
        $searchColumns = ['id', 'name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->studentCourse->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);
        $today = date("Y-m-d");
        $studentCourses = $query->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->where('due_date', $today);

        $studentCourses = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.students.payments.today', compact('studentCourses'));
    }
    public function tomorrowPayment()
    {
        $searchColumns = ['id', 'name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->studentCourse->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);
        $today = date("Y-m-d");
        $fdate = date('Y-m-d', strtotime('+1 day', strtotime($today)));
        $studentCourses = $query->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->where('due_date', $fdate);

        $studentCourses = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.students.payments.tomorrow', compact('studentCourses'));
    }
    public function threeDayPayment()
    {
        $searchColumns = ['id', 'name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->studentCourse->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);
        $today = date("Y-m-d");
        $fdate = date('Y-m-d', strtotime('+3 day', strtotime($today)));
        $studentCourses = $query->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->where('due_date', $fdate);

        $studentCourses = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.students.payments.threeday', compact('studentCourses'));
    }
    public function sevendayPayment()
    {
        $searchColumns = ['id', 'name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->studentCourse->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);
        $today = date("Y-m-d");
        $fdate = date('Y-m-d', strtotime('+7 day', strtotime($today)));
        $studentCourses = $query->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->whereBetween('due_date', [$today, $fdate])->orderBy('due_date', 'ASC');

        $studentCourses = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.students.payments.sevenday', compact('studentCourses'));
    }
    public function report(Request $request)
    {
        $query = $this->studentCourse->with('student', 'course');

        if (!is_null($request->name)) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            });
        }

        if (!is_null($request->email)) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('email', $request->email);
            });
        }

        if (!is_null($request->phone)) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('phone', $request->phone);
            });
        }

        if (!is_null($request->pick_date) && !is_null($request->to_date)) {
            $startDate = date("Y-m-d", strtotime($request->pick_date));
            $endDate = date("Y-m-d", strtotime($request->to_date));
            $query->whereBetween('paid_date', [$startDate, $endDate]);
        }

        $reports = $query->orderBy('paid_date', 'DESC')->paginate(50);
        return view('admin.students.payments.report', compact('reports'));
    }
    public function penaltyPayment()
    {
        $searchColumns = ['id', 'name', 'phone', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->student->query();
        $query->where('status', 2)->whereHas('studentcourse', function ($q) {
            $q->where('due_date', '<', date('Y-m-d'));
        });
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);
        $students = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.students.payments.penalty-payment', compact('students'));
    }
}
