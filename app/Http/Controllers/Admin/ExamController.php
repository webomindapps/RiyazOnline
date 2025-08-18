<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamRegistration;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(public ExamRegistration $registration) {}
    public function index(Request $request)
    {
        $searchColumns = ['id', 'f_name', 'email', 'phone','payment_status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->registration->query();

        if ($search != '')
            $query->whereHas('student', function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $registrations = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.exam.index',compact('registrations'));
    }
}
