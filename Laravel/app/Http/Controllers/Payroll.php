<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\PayrollE;

class Payroll extends Controller
{
    public function index1()
    {
        $employees = Employees::all(); // Retrieve all employees from the database
        $payroll = PayrollE::all();
        return view('payroll', compact('employees', 'payroll'));
        
    }
    public function savePayroll(Request $request)
    {
        $request->validate([
            'employeeName' => 'required',
            'rph' => 'required',
            'salary' => 'required',
            'twh' => 'required',
            'deduction' => 'required',
            'benefits' => 'required',
        ]);
        $id = $request->iD;
        $employeeName = $request->employeeName;
        $rph = $request->rph;
        $salary = $request->salary;
        $twh = $request->twh;
        $deduction = $request->deduction;
        $benefits = $request->benefits;
    
        $pay = new PayrollE();
        $pay->employeeName = $employeeName;
        $pay->rph = $rph;
        $pay->Salary = $salary;
        $pay->TotalHrs = $twh;
        $pay->SSS = $deduction;
        $pay->Benefits = $benefits;
        $pay->save();
    
        return redirect()->back()->with('success', 'Employee Payroll Added Successfully');
    }
}    