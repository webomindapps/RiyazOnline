<?php

use App\Http\Controllers\Admin\AdminMailController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\PaymentReminderController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'courses' => CourseController::class,
        'mails' => AdminMailController::class,
        'templates' => EmailTemplateController::class,
        'countries' => CountryController::class,
    ]);
    Route::get('/course/{id}/delete', [CourseController::class, 'delete'])->name('courses.delete');
    Route::post('/course/status/change', [CourseController::class, 'statusChng'])->name('courses.change_status');
    Route::post('/course/priority/change', [CourseController::class, 'updatePriority'])->name('courses.update_priority');
    Route::get('/course/export', [CourseController::class, 'export'])->name('courses.export');

    // mails
    Route::get('/mail/{id}/delete', [AdminMailController::class, 'delete'])->name('mails.delete');
    Route::post('/mail/status/change', [AdminMailController::class, 'statusChng'])->name('mails.change_status');

    // Student Details
    Route::get('/new-students', [StudentController::class, 'index'])->name('students.new');
    Route::get('/all-students', [StudentController::class, 'AllStudent'])->name('all.students');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student/create', [StudentController::class, 'store']);
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/{id}/edit', [StudentController::class, 'update']);
    Route::get('/student/{id}/details', [StudentController::class, 'details'])->name('student.details');
    Route::get('/new-student-export', [StudentController::class, 'newStudentExport'])->name('students.new.export');
    Route::get('/all-student-export', [StudentController::class, 'allStudentExport'])->name('students.all.export');
    Route::post('/student-import', [StudentController::class, 'studentImport'])->name('student.import');
    Route::post('/student-bulk-mail', [StudentController::class, 'bulkMail'])->name('student.bulk.mail');
    Route::get('/student/renew', [StudentController::class, 'renew'])->name('student.renew');
    Route::post('/student/renew', [StudentController::class, 'renewStore']);
    Route::get('/student/details-by-roll/{id}', [StudentController::class, 'getDetailsByRoll']);

    // Country status
    Route::post('/country/status/change', [CountryController::class, 'stausChng'])->name('countries.change.status');

    // Payment Reminders
    Route::get('/today/payments', [PaymentReminderController::class, 'todayPayment'])->name('payments.today');
    Route::get('/tomorrow/payments', [PaymentReminderController::class, 'tomorrowPayment'])->name('payments.tomorrow');
    Route::get('/threeday/payments', [PaymentReminderController::class, 'threeDayPayment'])->name('payments.threeday');
    Route::get('/sevenday/payments', [PaymentReminderController::class, 'sevendayPayment'])->name('payments.sevenday');
    Route::get('/penalty/payments', [PaymentReminderController::class, 'penaltyPayment'])->name('payments.penalty');
    Route::get('/payment/reports', [PaymentReminderController::class, 'report'])->name('payments.report');

    Route::post('/student/status/change', [StudentController::class, 'changeStatus'])->name('student.status.change');
    Route::post('/student/joining/date', [StudentController::class, 'addJoinDate'])->name('student.joinDt.change');

    // Attrition Students
    Route::get('/disabled/students', [StudentController::class, 'disabledStudents'])->name('students.disabled');

    // Invoice design
    Route::get('/invoice/{id}/details', [StudentController::class, 'viewInvoice'])->name('invoice.show');
});
Route::get('/get-email-content', [EmailTemplateController::class, 'getData'])->name('get.email.content');
