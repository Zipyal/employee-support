<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BriefingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmploymentContractController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TestAnswerVariantController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestQuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/briefings', [BriefingController::class, 'index'])->name('briefing');
    Route::get('/briefings/add', [BriefingController::class, 'add'])->name('briefing-add');
    Route::post('/briefings/add', [BriefingController::class, 'store'])->name('briefing-store');
    Route::get('/briefings/{id}', [BriefingController::class, 'show'])->name('briefing-show');
    Route::get('/briefings/{id}/edit', [BriefingController::class, 'edit'])->name('briefing-edit');
    Route::post('/briefings/{id}/edit', [BriefingController::class, 'update'])->name('briefing-update');
    Route::post('/briefings/{id}/delete', [BriefingController::class, 'delete'])->name('briefing-delete');

    Route::get('/materials', [MaterialController::class, 'index'])->name('material');
    Route::get('/materials/add', [MaterialController::class, 'add'])->name('material-add');
    Route::post('/materials/add', [MaterialController::class, 'store'])->name('material-store');
    Route::get('/materials/{id}', [MaterialController::class, 'show'])->name('material-show');
    Route::get('/materials/{id}/edit', [MaterialController::class, 'edit'])->name('material-edit');
    Route::post('/materials/{id}/edit', [MaterialController::class, 'update'])->name('material-update');
    Route::post('/materials/{id}/delete', [MaterialController::class, 'delete'])->name('material-delete');


    Route::post('/tests/questions/add', [TestQuestionController::class, 'store'])->name('test-add-question');
    Route::post('/tests/questions/{id}/delete', [TestQuestionController::class, 'delete'])->name('test-delete-question');

    Route::post('/tests/answers/add', [TestAnswerVariantController::class, 'store'])->name('test-add-answer');
    Route::post('/tests/answers/{id}/edit', [TestAnswerVariantController::class, 'update'])->name('test-edit-answer');
    Route::post('/tests/answers/{id}/delete', [TestAnswerVariantController::class, 'delete'])->name('test-delete-answer');

    Route::get('/tests', [TestController::class, 'index'])->name('test');
    Route::get('/tests/add', [TestController::class, 'add'])->name('test-add');
    Route::post('/tests/add', [TestController::class, 'store'])->name('test-store');
    Route::get('/tests/{id}', [TestController::class, 'show'])->name('test-show');
    Route::get('/tests/{id}/edit', [TestController::class, 'edit'])->name('test-edit');
    Route::post('/tests/{id}/edit', [TestController::class, 'update'])->name('test-update');
    Route::post('/tests/{id}/delete', [TestController::class, 'delete'])->name('test-delete');

    Route::post('/tasks/comments/add', [TaskCommentController::class, 'store'])->name('task-add-comment');

    Route::get('/tasks', [TaskController::class, 'index'])->name('task');
    Route::get('/tasks/add', [TaskController::class, 'add'])->name('task-add');
    Route::post('/tasks/add', [TaskController::class, 'store'])->name('task-store');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('task-show');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('task-edit');
    Route::post('/tasks/{id}/edit', [TaskController::class, 'update'])->name('task-update');
    Route::post('/tasks/{id}/delete', [TaskController::class, 'delete'])->name('task-delete');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/employees/add', [EmployeeController::class, 'add'])->name('employee-add');
    Route::post('/employees/add', [EmployeeController::class, 'store'])->name('employee-store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employee-show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employee-edit');
    Route::post('/employees/{id}/edit', [EmployeeController::class, 'update'])->name('employee-update');
    Route::post('/employees/{id}/delete', [EmployeeController::class, 'delete'])->name('employee-delete');

    Route::get('/employees/{employeeId}/contracts/add', [EmploymentContractController::class, 'add'])->name('employee-add-contract');
    Route::post('/employees/{employeeId}/contracts/add', [EmploymentContractController::class, 'store'])->name('employee-store-contract');
    Route::get('/employees/contracts/{contractId}', [EmploymentContractController::class, 'show'])->name('employee-show-contract');
    Route::get('/employees/contracts/{contractId}/edit', [EmploymentContractController::class, 'edit'])->name('employee-edit-contract');
    Route::post('/employees/contracts/{contractId}/edit', [EmploymentContractController::class, 'update'])->name('employee-update-contract');
    Route::post('/employees/contracts/{contractId}/delete', [EmploymentContractController::class, 'delete'])->name('employee-delete-contract');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('user-profile');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
