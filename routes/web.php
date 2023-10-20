<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;
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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/user_exam', [App\Http\Controllers\UserAnswerController::class, 'user_exam'])->name('user.user_exam');
    Route::post('/user_examSubmit', [App\Http\Controllers\UserAnswerController::class, 'examSubmit'])->name('user.exam_submit');
    Route::get('/user_examSubjective', [App\Http\Controllers\UserAnswerController::class, 'user_exam_subjective'])->name('user.user_exam_subjective');
    Route::post('/user_subjectiveStore', [App\Http\Controllers\UserAnswerController::class, 'subjectiveStore'])->name('user.subjectiveStore');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/exam', [App\Http\Controllers\UserAnswerController::class, 'exam'])->name('user.exam');
    Route::get('/question', [App\Http\Controllers\QuestionController::class, 'index'])->name('question');
    Route::post('/question', [App\Http\Controllers\QuestionController::class, 'index'])->name('question.filter');
    Route::get('/question_form', [App\Http\Controllers\QuestionController::class, 'create'])->name('question.form');
    Route::get('/question_editForm/{id}', [App\Http\Controllers\QuestionController::class, 'editForm'])->name('question.editForm');
    Route::post('/question_store', [App\Http\Controllers\QuestionController::class, 'store'])->name('question.store');
    Route::post('/question_edit', [App\Http\Controllers\QuestionController::class, 'edit'])->name('question.edit');
    Route::get('/question_delete/{id}', [App\Http\Controllers\QuestionController::class, 'destroy'])->name('question.delete');

    Route::post('/question_option_store', [App\Http\Controllers\QuestionController::class, 'question_option_store'])->name('question_option.store');
    Route::post('/question_option_edit', [App\Http\Controllers\QuestionController::class, 'question_option_edit'])->name('question_option.edit');
    Route::get('/question_option_delete/{id}', [App\Http\Controllers\QuestionController::class, 'question_option_delete'])->name('question_option.delete');

    Route::get('/student', [App\Http\Controllers\StudentController::class, 'index'])->name('student.index');
    Route::get('/student-user-answer/{id}', [App\Http\Controllers\StudentController::class, 'user_answer'])->name('student.userAnswer');
    Route::post('/student', [App\Http\Controllers\StudentController::class, 'index'])->name('student.filter');
    Route::get('/studentForm', [App\Http\Controllers\StudentController::class, 'form'])->name('student.form');
    Route::get('/studenteditForm/{id}', [App\Http\Controllers\StudentController::class, 'editForm'])->name('student.editForm');
    Route::post('/studentEdit', [App\Http\Controllers\StudentController::class, 'edit'])->name('student.edit');
    Route::get('/studentDelete/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('student.delete');
    Route::post('/studentCreate', [App\Http\Controllers\StudentController::class, 'create'])->name('student.create');
    Route::get('/studentPdf/{id}', [App\Http\Controllers\StudentController::class, 'pdf'])->name('student.pdf');
    Route::get('/studentPdf2/{id}', [App\Http\Controllers\StudentController::class, 'pdf2'])->name('student.pdf2');
});