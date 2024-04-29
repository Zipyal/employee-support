<?php

use App\Http\Controllers\MaterialController;
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


