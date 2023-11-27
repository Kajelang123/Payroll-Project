<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\PayrollE;
use App\Models\Timekeeping;
use Carbon\Carbon;

class Payroll extends Controller
{
    public function index1()
    {
        $employees = Employees::all(); // Retrieve all employees from the database
        $payroll = PayrollE::all();
        $timekeeping = Timekeeping::all();
        
        return view('payroll', compact('employees', 'payroll', 'timekeeping'));
        
    }
    public function savePayroll(Request $request)
    {
        $request->validate([
            'employeeID' => 'required',
            'employeeName' => 'required',
            'rph' => 'required',
            'salary' => 'required',
            'twh' => 'required',
            'deduction' => 'required',
            'benefits' => 'required',
        ]);
        $id = $request->iD;
        $employeeID = $request->employeeID;
        $employeeName = $request->employeeName;
        $rph = $request->rph;
        $salary = $request->salary;
        $twh = $request->twh;
        $deduction = $request->deduction;
        $benefits = $request->benefits;
    
        $pay = new PayrollE();
        $pay->employeeID = $employeeID; 
        $pay->employeeName = $employeeName;
        $pay->rph = $rph;
        $pay->Salary = $salary;
        $pay->TotalHrs = $twh;
        $pay->SSS = $deduction;
        $pay->Benefits = $benefits;
        $pay->save();
    
        return redirect()->back()->with('success', 'Employee Payroll Added Successfully');
    }
    
    public function calculateTotalHours($timeIn, $timeOut)
    {
    $timeIn = strtotime($timeIn);
    $timeOut = strtotime($timeOut);

    $timeDifference = $timeOut - $timeIn;

    return number_format($timeDifference /3600, 2);
}
    public function getTotalHours(Request $request){
        $employeeName = $request->input('employeeName');
        $startDate = $request->input('start_date');
        $endDate =$request->input('end_date');

        $employeeID = Timekeeping::where('EmployeeName', $employeeName)
        ->value('EmployeeID');
        $totalHours =$this->calculateTotalHoursForDateRange($employeeName, $startDate, $endDate);

        return response()->json(['totalHours' => $totalHours, 'employeeID' =>$employeeID]);
    }
    public function calculateTotalHoursForDateRange($employeeName, $startDate, $endDate)
    {
        // Use Carbon for date manipulation
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate)->endOfDay();

        
        $timekeeping = Timekeeping::where('EmployeeName', $employeeName)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalHours = 0;

        
        foreach ($timekeeping as $time) {
            $totalHours += $this->calculateTotalHours($time->TimeIn, $time->TimeOut);
        }

        return number_format($totalHours, 2);
    }
}    