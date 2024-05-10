<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EmployeeController;
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


Route::get('/tasks', [EmployeeController::class, 'index'])->name('tasks');
Route::get('/tasks/add', [EmployeeController::class, 'add'])->name('tasks-add');
Route::post('/tasks/add', [EmployeeController::class, 'store'])->name('tasks-store');
Route::get('/tasks/{id}', [EmployeeController::class, 'show'])->name('tasks-show');
Route::get('/tasks/{id}/edit', [EmployeeController::class, 'edit'])->name('tasks-edit');
Route::post('/tasks/{id}/edit', [EmployeeController::class, 'update'])->name('tasks-update');
Route::post('/tasks/{id}/delete', [EmployeeController::class, 'delete'])->name('tasks-delete');


Route::get('/tests', [EmployeeController::class, 'index'])->name('tests');
Route::get('/tests/add', [EmployeeController::class, 'add'])->name('tests-add');
Route::post('/tests/add', [EmployeeController::class, 'store'])->name('tests-store');
Route::get('/tests/{id}', [EmployeeController::class, 'show'])->name('tests-show');
Route::get('/tests/{id}/edit', [EmployeeController::class, 'edit'])->name('tests-edit');
Route::post('/tests/{id}/edit', [EmployeeController::class, 'update'])->name('tests-update');
Route::post('/tests/{id}/delete', [EmployeeController::class, 'delete'])->name('tests-delete');

Route::get('/briefings', [BriefingController::class, 'index'])->name('briefing');
Route::get('/briefings/add', [BriefingController::class, 'add'])->name('briefing-add');
Route::post('/briefings/add', [BriefingController::class, 'store'])->name('briefing-store');
Route::get('/briefings/{id}', [BriefingController::class, 'show'])->name('briefing-show');
Route::get('/briefings/{id}/edit', [BriefingController::class, 'edit'])->name('briefing-edit');
Route::post('/briefings/{id}/edit', [BriefingController::class, 'update'])->name('briefing-update');
Route::post('/briefings/{id}/delete', [BriefingController::class, 'delete'])->name('briefing-delete');
