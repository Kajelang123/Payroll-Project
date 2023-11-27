<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Payroll;
use App\Http\Controllers\TimekeepingController;
use App\Http\Controllers\UserManagementController;

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/aboutus', function () {
    return view('home');
});
Route::get('/payroll', function () {
    return view('Payroll');
});

Route::get('/Timekeeping', function () {
    return view('TimeKeeping');
});

Route::get('/UserManagement', function(){
    return view ('UserManagement');
});

Route::get('/login', function(){
    return view ('Login');
});

Route::get('employees', [EmployeesController::class, 'index']);

Route::get('addemployees', [EmployeesController::class, 'addEmployee']);
Route::get('payroll', [Payroll::class, 'index1'])->name('employees.index');
Route::get('Timekeeping', [TimekeepingController::class, 'index']);
Route::get('UserManagement',[UserManagementController::class, 'index']);

Route::get('edit-employees/{id}', [EmployeesController::class, 'editEmployee'])->name('employees.edit');
Route::get('delete-employees/{id}', [EmployeesController::class, 'deleteEmployee'])->name('employees.edit');

//Employees Management
Route::post('save-employee', [EmployeesController::class, 'saveEmployee']);
Route::post('update-employee', [EmployeesController::class, 'updateEmployees']);
//UserManagment
Route::post('saveUser', [UserManagementController::class, 'adduser']);
Route::post('login', [UserManagementController::class, 'LoginM']);
//Payroll
Route::post('save-payroll', [Payroll::class, 'savePayroll'])->name('save-payroll');
Route::get('/getTotalHours', [Payroll::class, 'getTotalHours'])->name('getTotalHours');
//Timekeeping
Route::post('/',[TimekeepingController::class, 'scan']);




Route::post('/submit-form', [Payroll::class, 'submitForm'])->name('submit-form');

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);

