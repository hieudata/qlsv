<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Models\Faculty;
use App\Models\Subject;



Route::get('/', function () {
    $students = Student::count();
    $faculties = Faculty::count();
    $subjects = Subject::count();
    return view('layouts.home', compact('students', 'faculties', 'subjects'));
})->name('home');
Route::resources([
    'faculties' => FacultyController::class,
    'students' => StudentController::class,
    'subjects' => SubjectController::class,
]);

// Form Filter
Route::controller(StudentController::class)->group(function () {
    // Route::get('students/{id}/addSubject', 'addSubject')->name('addSubject');
    // Route::post('students/{id}/save', 'saveSubject')->name('saveSubject');
    // Route::get('students/{id}/updatePoint', 'updatePoint')->name('updatePoint');
    // Route::post('students/{id}/point', 'savePoint')->name('savePoint');
    // Route::get('all', 'allSubject');
    // Route::post('alll', 'getSubject')->name('getSubject');
    Route::get('student/login', 'login')->name('student.login');
    Route::post('student/check', 'check')->name('student.check');
    Route::get('student/dashboard', 'dashboard');
    Route::get('student/logout', 'logout')->name('student.logout');
    Route::get('send-mail', 'sendmail')->name('sendmail');
    Route::get('students/ajax/{id}', 'getStudent');
    Route::post('students/ajax', 'updateStudent')->name('student.update');
    // ***** SLUG *****
    Route::get('students/{student:slug}', 'show')->name('student.slug');
    Route::get('check-slug', 'checkSlug');
    // ***** Localization ******
    Route::get('language/{locale}', 'setLang')->name('locale');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('dashboard',  'dashboard');
    Route::get('admin/login',  'index')->name('login');
    Route::post('admincustom-login',  'customLogin')->name('login.custom');
    Route::get('admin/register',  'registration')->name('register-user');
    Route::post('admin/custom-register',  'customRegistration')->name('register.custom');
    Route::get('signout',  'signOut')->name('signout');
});

Route::get('students/{id}/addSubject', [StudentController::class, 'addSubject'])->name('addSubject');
Route::post('students/{id}/save', [StudentController::class, 'saveSubject'])->name('saveSubject');
Route::get('students/{id}/updatePoint', [StudentController::class, 'updatePoint'])->name('updatePoint');
Route::post('students/{id}/point', [StudentController::class, 'savePoint'])->name('savePoint');
Route::get('products/ajax/{id}', [StudentController::class, 'getProductId']);
Route::post('products/ajax/', [StudentController::class, 'updateProduct'])->name('products.update2');