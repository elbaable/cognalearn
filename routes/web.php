<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\CourseController::class, 'index']);
Route::post('/', [App\Http\Controllers\CourseController::class, 'index']);
Route::get('course/{id}', [App\Http\Controllers\CourseController::class, 'detail']);
Route::post('add-course', [App\Http\Controllers\CourseController::class, 'store']);
Route::get('edit-course/{id}', [App\Http\Controllers\CourseController::class, 'edit']);
Route::post('update-course', [App\Http\Controllers\CourseController::class, 'update']);
Route::get('delete-course/{id}', [App\Http\Controllers\CourseController::class, 'delete']);
Route::get('teachers', [App\Http\Controllers\TeacherController::class, 'index']);
Route::post('teachers', [App\Http\Controllers\TeacherController::class, 'index']);
Route::get('teacher/{id}', [App\Http\Controllers\TeacherController::class, 'detail']);
Route::post('add-teacher', [App\Http\Controllers\TeacherController::class, 'store']);
Route::get('edit-teacher/{id}', [App\Http\Controllers\TeacherController::class, 'edit']);
Route::post('update-teacher', [App\Http\Controllers\TeacherController::class, 'update']);
Route::get('delete-teacher/{id}', [App\Http\Controllers\TeacherController::class, 'delete']);
Route::post('add-teachers', [App\Http\Controllers\CourseController::class, 'add_teachers']);
Route::post('add-courses', [App\Http\Controllers\TeacherController::class, 'add_courses']);