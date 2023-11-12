<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Payroll;

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/aboutus', function () {
    return view('home');
});
Route::get('/payroll', function () {
    return view('Payroll');
});

Route::get('/timekeeping', function () {
    return view('TimeKeeping');
});


Route::get('employees', [EmployeesController::class, 'index']);
Route::get('addemployees', [EmployeesController::class, 'addEmployee']);
Route::get('payroll', [Payroll::class, 'index1'])->name('employees.index');

Route::get('edit-employees/{id}', [EmployeesController::class, 'editEmployee'])->name('employees.edit');
Route::get('delete-employees/{id}', [EmployeesController::class, 'deleteEmployee'])->name('employees.edit');

//User Management
Route::post('save-employee', [EmployeesController::class, 'saveEmployee']);
Route::post('update-employee', [EmployeesController::class, 'updateEmployees']);
//Payroll
Route::post('save-payroll', [Payroll::class, 'savePayroll'])->name('save-payroll');


Route::post('/submit-form', [Payroll::class, 'submitForm'])->name('submit-form');

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
