<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\GoogleSocialiteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

Route::resources([
    'faculties' => FacultyController::class,
    'students' => StudentController::class,
    'subjects' => SubjectController::class,
]);

Route::controller(StudentController::class)->group(function () {
    Route::get('students/{id}/addSubject', 'addSubject')->name('addSubject');
    Route::post('students/{id}/save', 'saveSubject')->name('saveSubject');
    Route::get('students/{id}/updatePoint', 'updatePoint')->name('updatePoint');
    Route::post('students/{id}/point', 'savePoint')->name('savePoint');
    Route::get('student/login', 'login')->name('student.login');
    Route::post('student/check', 'check')->name('student.check');
    Route::get('student/dashboard', 'dashboard');
    Route::get('student/logout', 'logout')->name('student.logout');
    Route::get('send-mail', 'sendmail')->name('sendmail');
    Route::get('students/ajax/{id}', 'getStudent');
    Route::post('students/ajax', 'updateStudent')->name('student.update');
    Route::get('students/{student:slug}', 'show')->name('student.slug');
    Route::get('check-slug', 'checkSlug');
    Route::get('language/{locale}', 'setLang')->name('locale');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('dashboard',  'dashboard');
    Route::get('admin/login',  'index')->name('login');
    Route::post('admincustom-login',  'customLogin')->name('login.custom');
    Route::get('admin/register',  'registration')->name('register-user');
    Route::post('admin/custom-register',  'customRegistration')->name('register.custom');
    Route::get('signout', 'signOut')->name('signout');
});
Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback']);
Route::get('home', [GoogleSocialiteController::class, 'signOut'])->name('singOut');

