<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $courseCount = Course::count();
        $newStudentCount = StudentDetail::where('status', 1)->count();
        $existingStudentCount = StudentDetail::where('status', 2)->count();
        $today = date("Y-m-d");
        $Threedays = date('Y-m-d', strtotime('+3 day', strtotime($today)));
        $sevenDays = date('Y-m-d', strtotime('+7 day', strtotime($today)));
        $todayPaymentCount = StudentCourseDetail::whereHas('student', function ($query) {
            $query->where('status', 2);
        })->whereDate('due_date', $today)->count();
        $threeDaysPaymentCount = StudentCourseDetail::whereHas('student', function ($query) {
            $query->where('status', 2);
        })->whereDate('due_date', $Threedays)->count();
        $sevenDaysPaymentCount = StudentCourseDetail::whereHas('student', function ($query) {
            $query->where('status', 2);
        })->whereBetween('due_date', [$today, $sevenDays])->count();
        return view('admin.dashboard', compact('courseCount', 'newStudentCount', 'existingStudentCount', 'todayPaymentCount', 'threeDaysPaymentCount', 'sevenDaysPaymentCount'));
    }
}
