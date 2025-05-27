<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/student/{id}/registration', [HomeController::class, 'courseDetails'])->name('new.registration');
Route::post('/student/{id}/registration', [HomeController::class, 'studentCreate']);
Route::post('/payment/confirm', [HomeController::class, 'studentStore'])->name('payment.confirm');
Route::post('/renewal/payment/confirm', [HomeController::class, 'renewalStore'])->name('renewal.payment.confirm');
Route::get('/existing-student', [HomeController::class, 'existingStudent'])->name('existing.student');
Route::post('/get-student-details', [HomeController::class, 'getStudentDetails'])->name('get.student.details');
Route::post('/getCourseDetails', [HomeController::class, 'getStudentDetails'])->name('getCourseDetails');
Route::post('/existing/course/details', [HomeController::class, 'getCourseDetails'])->name('existing.course.details');
Route::get('/complete/{id}/registration', [HomeController::class, 'completeRegistrationView'])->name('complete.registration');
Route::post('/complete/{id}/registration', [HomeController::class, 'completeRegistration']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
