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
use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('briefings')->group(function () {
        Route::get('/', [BriefingController::class, 'index'])->name('briefing');
        Route::get('/add', [BriefingController::class, 'add'])->name('briefing-add');
        Route::post('/add', [BriefingController::class, 'store'])->name('briefing-store');
        Route::get('/{id}', [BriefingController::class, 'show'])->name('briefing-show');
        Route::get('/{id}/edit', [BriefingController::class, 'edit'])->name('briefing-edit');
        Route::post('/{id}/edit', [BriefingController::class, 'update'])->name('briefing-update');
        Route::post('/{id}/delete', [BriefingController::class, 'delete'])->name('briefing-delete');
    });

    Route::prefix('materials')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('material');
        Route::get('/add', [MaterialController::class, 'add'])->name('material-add');
        Route::post('/add', [MaterialController::class, 'store'])->name('material-store');
        Route::get('/{id}', [MaterialController::class, 'show'])->name('material-show');
        Route::get('/{id}/edit', [MaterialController::class, 'edit'])->name('material-edit');
        Route::post('/{id}/edit', [MaterialController::class, 'update'])->name('material-update');
        Route::post('/{id}/delete', [MaterialController::class, 'delete'])->name('material-delete');
    });

    Route::prefix('tests')->group(function () {

        Route::get('/', [TestController::class, 'index'])->name('test');

        Route::middleware(RoleMiddleware::class . ':' . implode(',', [User::ROLE_ADMIN, User::ROLE_MENTOR]))->group(function() {
            Route::post('/questions/add', [TestQuestionController::class, 'store'])->name('test-add-question');
            Route::post('/questions/{id}/delete', [TestQuestionController::class, 'delete'])->name('test-delete-question');

            Route::post('/answers/add', [TestAnswerVariantController::class, 'store'])->name('test-add-answer');
            Route::post('/answers/{id}/edit', [TestAnswerVariantController::class, 'update'])->name('test-edit-answer');
            Route::post('/answers/{id}/delete', [TestAnswerVariantController::class, 'delete'])->name('test-delete-answer');

            Route::get('/add', [TestController::class, 'add'])->name('test-add');
            Route::post('/add', [TestController::class, 'store'])->name('test-store');

            Route::get('/{id}/edit', [TestController::class, 'edit'])->name('test-edit');
            Route::post('/{id}/edit', [TestController::class, 'update'])->name('test-update');
            Route::post('/{id}/delete', [TestController::class, 'delete'])->name('test-delete');
        });
        Route::get('/{id}', [TestController::class, 'show'])->name('test-show');
    });

    Route::prefix('tasks')->group(function () {
        Route::post('/comments/add', [TaskCommentController::class, 'store'])->name('task-add-comment');
        Route::get('/', [TaskController::class, 'index'])->name('task');

        Route::middleware(RoleMiddleware::class . ':' . implode(',', [User::ROLE_ADMIN, User::ROLE_MENTOR]))->group(function() {
            Route::get('/add', [TaskController::class, 'add'])->name('task-add');
            Route::post('/add', [TaskController::class, 'store'])->name('task-store');
            Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('task-edit');
            Route::post('/{id}/edit', [TaskController::class, 'update'])->name('task-update');
            Route::post('/{id}/delete', [TaskController::class, 'delete'])->name('task-delete');
        });

        Route::get('/{id}', [TaskController::class, 'show'])->name('task-show');
    });

    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee');
        Route::get('/add', [EmployeeController::class, 'add'])->name('employee-add');
        Route::post('/add', [EmployeeController::class, 'store'])->name('employee-store');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('employee-show');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employee-edit');
        Route::post('/{id}/edit', [EmployeeController::class, 'update'])->name('employee-update');
        Route::post('/{id}/delete', [EmployeeController::class, 'delete'])->name('employee-delete');

        Route::get('/{employeeId}/contracts/add', [EmploymentContractController::class, 'add'])->name('employee-add-contract');
        Route::post('/{employeeId}/contracts/add', [EmploymentContractController::class, 'store'])->name('employee-store-contract');
        Route::get('/contracts/{contractId}', [EmploymentContractController::class, 'show'])->name('employee-show-contract');
        Route::get('/contracts/{contractId}/edit', [EmploymentContractController::class, 'edit'])->name('employee-edit-contract');
        Route::post('/contracts/{contractId}/edit', [EmploymentContractController::class, 'update'])->name('employee-update-contract');
        Route::post('/contracts/{contractId}/delete', [EmploymentContractController::class, 'delete'])->name('employee-delete-contract');
    });

    Route::get('/profile', [UserController::class, 'profile'])->name('user-profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
