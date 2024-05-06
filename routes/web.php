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

Route::get('/mentors', [EmployeeController::class, 'index'])->name('mentors');
Route::get('/mentors/add', [EmployeeController::class, 'add'])->name('mentor-add');
Route::post('/mentors/add', [EmployeeController::class, 'store'])->name('mentor-store');
Route::get('/mentors/{id}', [EmployeeController::class, 'show'])->name('mentor-show');
Route::get('/mentors/{id}/edit', [EmployeeController::class, 'edit'])->name('mentor-edit');
Route::post('/mentors/{id}/edit', [EmployeeController::class, 'update'])->name('mentor-update');
Route::post('/mentors/{id}/delete', [EmployeeController::class, 'delete'])->name('mentor-delete');


