<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/student/{id}/registration', [HomeController::class, 'courseDetails'])->name('new.registration');
Route::post('/student/{id}/registration', [HomeController::class, 'studentCreate']);
Route::post('/payment-initiate', [PaymentController::class, 'paymentInitiate'])->name('payment.initiate');
Route::post('/payment/confirm/{id}', [PaymentController::class, 'paymentConfirm'])->name('payment.confirm');
Route::post('/renewal/payment/initiate', [PaymentController::class, 'renewalPaymentInitiate'])->name('renewal.payment.initiate');
Route::post('/renewal/payment/confirm/{id}', [PaymentController::class, 'renewalPaymentConfirm'])->name('renewal.payment.confirm');
Route::get('/student/{tempid}/store', [HomeController::class, 'studentStore'])->name('student.store');
Route::get('/renewal/{id}/store', [HomeController::class, 'renewalStore'])->name('renewal.store');
Route::get('/existing-student', [HomeController::class, 'existingStudent'])->name('existing.student');
Route::post('/get-student-details', [HomeController::class, 'getStudentDetails'])->name('get.student.details');
Route::post('/getCourseDetails', [HomeController::class, 'getStudentDetails'])->name('get.student.details');
Route::post('/existing/course/details', [HomeController::class, 'getCourseDetails'])->name('existing.course.details');
Route::get('/complete/{id}/registration', [HomeController::class, 'completeRegistrationView'])->name('complete.registration');
Route::post('/complete/{id}/registration', [HomeController::class, 'completeRegistration']);
Route::get('/missing-a-class', [HomeController::class, 'missingClass'])->name('missing.class');
Route::get('/autocomplete-search', [StudentController::class, 'autocompleteSearch']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/sendSMS', [HomeController::class, 'sendSMS'])->name('send.sms');
Route::get('/get-states/{id}', [HomeController::class, 'getStates'])->name('get.states');
Route::get('/get-cities/{id}', [HomeController::class, 'getCities'])->name('get.cities');

require __DIR__ . '/auth.php';
