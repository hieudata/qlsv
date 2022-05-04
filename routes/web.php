<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('faculties', FacultyController::class);
