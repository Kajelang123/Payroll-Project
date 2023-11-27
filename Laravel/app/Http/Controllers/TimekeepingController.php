<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Timekeeping;
use App\Models\PayrollE;
use Carbon\Carbon;

class TimekeepingController extends Controller
{
    public function index()
    {
        $employees = Employees::all();
        $timekeeping = Timekeeping::all();
        return view('timekeeping', compact('employees','timekeeping'));
    }
    

    public function scan(Request $request)
    {
        $rfidValue = $request->input('rfid');
        $currentTime = Carbon::now();
    
        $employee = Employees::where('EmployeeID', $rfidValue)->first();
    
        if (!$employee) {
            return redirect()->back()->with('failed', 'Employee Not Found.');
        }
    
        $timekeeping = Timekeeping::where('EmployeeID', $rfidValue)->latest()->first();
    
        if ($timekeeping && !$timekeeping->TimeOut) {
    
            $timekeeping->update(['TimeOut' => $currentTime]);
            return redirect()->back()->with('success', 'Time Out recorded succesfully.');
        }
    
        Timekeeping::create([
            'EmployeeID' => $employee->EmployeeID,
            'EmployeeName'=>$employee->FirstName .' '. $employee->MiddleName .' '. $employee->LastName,
            'TimeIn' => $currentTime,
        ]);
    
        return redirect()->back()->with('success', 'Time In recorded successfully.');
    }
}
