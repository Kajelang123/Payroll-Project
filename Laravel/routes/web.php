<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/aboutus', function () {
    return view('home');
});

Route::get('employees', [EmployeesController::class, 'index'])->name('employees.index');
Route::get('addemployees', [EmployeesController::class, 'addEmployee'])->name('employees.index');

Route::get('edit-employees/{id}', [EmployeesController::class, 'editEmployee'])->name('employees.edit');


Route::post('save-employee', [EmployeesController::class, 'saveEmployee']);
Route::post('update-employee', [EmployeesController::class, 'updateEmployees']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
