<?php

namespace App\Http\Controllers;

use App\Mail\DueToday;
use App\Models\StudentCourseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CronjobController extends Controller
{
    public function todayDues()
    {
        $today = date("Y-m-d");
        $studentCourses = StudentCourseDetail::with('student')->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->where('due_date', $today)
            ->whereIn('id', function ($sub) {
                $sub->selectRaw('MAX(id)')
                    ->from('student_course_details')
                    ->groupBy('student_id');
            })->get();
        foreach ($studentCourses as $course) {
            $userId = 'riyaazobiz';
            $password = 'uebj8002UE';
            $senderId = 'RYZONL';
            $phoneNumber = $course->student->phone;
            $message = 'Dear ' . $course->student->f_name . ', Greetings from RiyaazOnline music classes. Kindly note, that your fees due date is on ' . date('d-m-Y') . ' of every month. Kindly make the payment on or before the due date to continue your lessons smoothly. Please ignore if already paid. Thank you';
            $entityId = '1701172914234060146';
            $templateId = '1707173821059462047';
            $email = $course->student?->email;
            Mail::to($email)->send(new DueToday($course));
            $this->sendSingleSms($userId, $password, $senderId, $phoneNumber, $message, $entityId, $templateId);
        }
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
    public function threeDayReminder()
    {
        $today = date("Y-m-d");
        $third_date = date('Y-m-d', strtotime('+3 days', strtotime($today)));
        $studentCourses = StudentCourseDetail::with('student')->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->where('due_date', $third_date)->whereIn('id', function ($sub) {
            $sub->selectRaw('MAX(id)')
                ->from('student_course_details')
                ->groupBy('student_id');
        })->get();
        foreach ($studentCourses as $course) {
            $userId = 'riyaazobiz';
            $password = 'uebj8002UE';
            $senderId = 'RYZONL';
            $phoneNumber = $course->student->phone;
            $message = 'Dear ' . $course->student->f_name . ', Greetings from RiyaazOnline music classes. Kindly note, that your fees due date is on ' . date('d-m-Y', strtotime($third_date)) . ' of every month. Kindly make the payment on or before the due date to continue your lessons smoothly. Please ignore if already paid. Thank you';
            $entityId = '1701172914234060146';
            $templateId = '1707173821059462047';
            $email = $course->student?->email;
            Mail::to($email)->send(new DueToday($course));
            $this->sendSingleSms($userId, $password, $senderId, $phoneNumber, $message, $entityId, $templateId);
        }
    }
    public function sevenDayReminder()
    {
        $today = date("Y-m-d");
        $seven_date = date('Y-m-d', strtotime('+7 days', strtotime($today)));
        $studentCourses = StudentCourseDetail::with('student')->whereHas('student', function ($q) {
            $q->where('status', 2);
        })->where('due_date', $seven_date)->get();
        foreach ($studentCourses as $course) {
            $userId = 'riyaazobiz';
            $password = 'uebj8002UE';
            $senderId = 'RYZONL';
            $phoneNumber = $course->student->phone;
            $message = 'Dear ' . $course->student->f_name . ', Greetings from RiyaazOnline music classes. Kindly note, that your fees due date is on ' . date('d-m-Y', strtotime($seven_date)) . ' of every month. Kindly make the payment on or before the due date to continue your lessons smoothly. Please ignore if already paid. Thank you';
            $entityId = '1701172914234060146';
            $templateId = '1707173821059462047';
            $email = $course->student?->email;
            Mail::to($email)->send(new DueToday($course));
            $this->sendSingleSms($userId, $password, $senderId, $phoneNumber, $message, $entityId, $templateId);
        }
    }
}
