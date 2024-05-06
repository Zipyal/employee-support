<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/materials', [MaterialController::class, 'index']);
Route::get('/materials/add', [MaterialController::class, 'add'])->name('material-add');
Route::post('/materials/add', [MaterialController::class, 'create'])->name('material-create');
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

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
Route::get('/employee/add', [EmployeeController::class, 'add'])->name('employee-add');
Route::post('/employee/add', [EmployeeController::class, 'store'])->name('employee-store');
Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('employee-show');
Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee-edit');
Route::post('/employee/{id}/edit', [EmployeeController::class, 'update'])->name('employee-update');
Route::post('/employee/{id}/delete', [EmployeeController::class, 'delete'])->name('employee-delete');


