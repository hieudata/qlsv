<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentSubjectController;
use App\Models\Student;

Route::get('/', function () {
    return view('welcome');
});
Route::resources([
    'faculties' => FacultyController::class,
    'students' => StudentController::class,
    'subjects' => SubjectController::class,
    
]);

