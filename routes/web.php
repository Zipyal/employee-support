<?php

use App\Http\Controllers\BriefingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/materials', [MaterialController::class, 'index'])->name('material');
Route::get('/materials/add', [MaterialController::class, 'add'])->name('material-add');
Route::post('/materials/add', [MaterialController::class, 'store'])->name('material-store');
Route::get('/materials/{id}', [MaterialController::class, 'show'])->name('material-show');
Route::get('/materials/{id}/edit', [MaterialController::class, 'edit'])->name('material-edit');
Route::post('/materials/{id}/edit', [MaterialController::class, 'update'])->name('material-update');
Route::post('/materials/{id}/delete', [MaterialController::class, 'delete'])->name('material-delete');

Route::get('/tests', function () {
    return view('tests');
});

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/employees', [EmployeeController::class, 'index'])->name('employee');
Route::get('/employees/add', [EmployeeController::class, 'add'])->name('employee-add');
Route::post('/employees/add', [EmployeeController::class, 'store'])->name('employee-store');
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employee-show');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employee-edit');
Route::post('/employees/{id}/edit', [EmployeeController::class, 'update'])->name('employee-update');
Route::post('/employees/{id}/delete', [EmployeeController::class, 'delete'])->name('employee-delete');


Route::get('/tasks', [TaskController::class, 'index'])->name('task');
Route::get('/tasks/add', [TaskController::class, 'add'])->name('tasks-add');
Route::post('/tasks/add', [TaskController::class, 'store'])->name('tasks-store');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks-show');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks-edit');
Route::post('/tasks/{id}/edit', [TaskController::class, 'update'])->name('tasks-update');
Route::post('/tasks/{id}/delete', [TaskController::class, 'delete'])->name('tasks-delete');


Route::get('/tests', [TestController::class, 'index'])->name('test');
Route::get('/tests/add', [TestController::class, 'add'])->name('test-add');
Route::post('/tests/add', [TestController::class, 'store'])->name('test-store');
Route::get('/tests/{id}', [TestController::class, 'show'])->name('test-show');
Route::get('/tests/{id}/edit', [TestController::class, 'edit'])->name('test-edit');
Route::post('/tests/{id}/edit', [TestController::class, 'update'])->name('test-update');
Route::post('/tests/{id}/delete', [TestController::class, 'delete'])->name('test-delete');

Route::get('/briefings', [BriefingController::class, 'index'])->name('briefing');
Route::get('/briefings/add', [BriefingController::class, 'add'])->name('briefing-add');
Route::post('/briefings/add', [BriefingController::class, 'store'])->name('briefing-store');
Route::get('/briefings/{id}', [BriefingController::class, 'show'])->name('briefing-show');
Route::get('/briefings/{id}/edit', [BriefingController::class, 'edit'])->name('briefing-edit');
Route::post('/briefings/{id}/edit', [BriefingController::class, 'update'])->name('briefing-update');
Route::post('/briefings/{id}/delete', [BriefingController::class, 'delete'])->name('briefing-delete');
