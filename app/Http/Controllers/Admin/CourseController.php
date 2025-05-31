<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CourseExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public function __construct(public Course $course) {}

    public function index()
    {
        $searchColumns = ['id', 'course_name', 'new_student_fees', 'old_student_fees', 'priority', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->course->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $courses = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.courses.index', compact('courses'));
    }
    public function create()
    {
        return view('admin.courses.create');
    }
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $this->course->create($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }
    public function edit($id)
    {
        $course = $this->course->findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }
    public function update(CourseRequest $request, $id)
    {
        $data = $request->validated();
        $course = $this->course->findOrFail($id);
        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }
    public function updatePriority(Request $request)
    {
        $course = $this->course->find($request->id);
        $course->update([
            'priority' => $request->priority,
        ]);
        return ['status' => 'success'];
    }
    public function statusChng(Request $request)
    {
        $course = $this->course->find($request->id);
        if ($course->status == 0) {
            $course->status = 1;
            $course->save();
        } else {
            $course->status = 0;
            $course->save();
        }
        return ['status' => 'success'];
    }
    public function export()
    {
        return Excel::download(new CourseExport, 'Courses.xlsx');
    }
}
