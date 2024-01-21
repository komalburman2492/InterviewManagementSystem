<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Candidate\InterviewController;
use App\Http\Controllers\Interviewer\InterviewerController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Role routes
    Route::get('/admin/interviews', [AdminController::class,'index'])->name('admin.interviews.list');
    Route::get('admin/interview-details', [AdminController::class, 'getInterviewDetails'])->name('admin.interview-details');
});

Route::middleware(['auth','interviewer'])->group(function () {
    // Interviewer Role routes
    Route::get('/interviews', [InterviewerController::class,'index'])->name('interviews.list');
    Route::get('/interviews/create', [InterviewerController::class, 'create'])->name('interviews.create');
    Route::get('/interviews/{interview}/edit', [InterviewerController::class, 'edit'])->name('interviews.edit');
    Route::get('/interviews/{interview}/add-feedback', [InterviewerController::class, 'addFeedback'])->name('interviews.addFeedback');
    Route::delete('/interviews/{interview}', [InterviewerController::class, 'destroy'])->name('interviews.destroy');
    Route::post('/interviews', [InterviewerController::class, 'store'])->name('interviews.store');
});

Route::middleware(['auth','candidate'])->group(function () {
    // Candidate Role routes
    Route::get('/candidate/interviews', [InterviewController::class,'index'])->name('candidate.interviews-list');
    Route::get('candidate/interview-details', [InterviewController::class, 'getInterviewDetails'])->name('candidate.interview-details');
});
