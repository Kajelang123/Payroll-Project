<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\PayrollE;
use App\Models\Timekeeping;
use App\Models\Taxation;
use Spatie\ActivityLog\Models\Activity;
use Carbon\Carbon;
use PDF;

class Payroll extends Controller
{
    public function index1()
    {
        $employees = Employees::all(); // Retrieve all employees from the database
        $payroll = PayrollE::paginate(6);
        $timekeeping = Timekeeping::all();
        
        return view('payroll', compact('employees', 'payroll', 'timekeeping'));
        
    }
    public function index2()
    {
        $employees = Employees::all(); // Retrieve all employees from the database
        $payroll = PayrollE::paginate(9);
        $timekeeping = Timekeeping::all();
        
        return view('reports', compact('employees', 'payroll', 'timekeeping'));
        
    }
    public function index3()
    {
        $employees = Employees::all(); // Retrieve all employees from the database
        $payroll = PayrollE::paginate(9);
        $timekeeping = Timekeeping::all();
        
        return view('ownerreports', compact('employees', 'payroll', 'timekeeping'));
        
    }
    public function savePayroll(Request $request)
    {
        $request->validate([
            'employeeID' => 'required',
            'employeeName' => 'required',
            'rph' => 'required',
            'salary',
            'twh' => 'required',
        ]);
        $id = $request->iD;
        $employeeID = $request->employeeID;
        $employeeName = $request->employeeName;
        $rph = $request->rph;
        $twh = $request->twh;
        $sss = $request->sss;
        $philhealth = $request->philhealth;
        $pagibig = $request->pagibig;
        $late = $request->late;
        $benefits = $request->benefits;
        
       
        $s3 = $request->sss;
        $ph = $request->philhealth;
        $trulab = $request->pagibig;
        $totalLate = $request->late;
        $totalovertime = $request->toh;
        $taxs = $request->tax;
        $totalHoursWorked = $twh;
        $totalHoursWorkedwithLate = $totalHoursWorked - $totalovertime;

        $salary = $request->salary;
        $grossincome = $salary +  $benefits;
        $totaldeduction = $s3 + $ph + $trulab +$taxs;
        $netincome = $grossincome - $totaldeduction;

        $tax = new Taxation();
        $tax->EmployeeID = $employeeID;
        $tax->EmployeeName = $employeeName;
        $tax->SSS = $sss;
        $tax->PHILHEALTH = $philhealth;
        $tax->PAGIBIG = $pagibig;
        $tax->save();

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $weekNumber = $startDate->weekOfMonth;

        $pay = new PayrollE();
        $pay->employeeID = $employeeID; 
        $pay->employeeName = $employeeName;
        $pay->rph = $rph;
        $pay->Salary = $salary;
        $pay->TotalHrs = $twh;
        $pay->Overtime = $totalovertime;
        $pay->GrossIncome = $grossincome;
        $pay->SSS = $sss;
        $pay->PHILHEALTH = $philhealth;
        $pay->PAGIBIG = $pagibig;
        $pay->TotalDeduction =$totaldeduction;
        $pay->Benefits = $benefits;
        $pay->NetIncome = $netincome;
        $pay->week_number= $weekNumber;
        $pay->save();
    
        return redirect()->back()->with('success', 'Employee Payroll Added Successfully');
    }
    
    public function calculateTotalHours($timeIn, $timeOut)
    {
    $timeIn = strtotime($timeIn);
    $timeOut = strtotime($timeOut);

    $timeDifference = $timeOut - $timeIn;

    return $timeDifference / 3600;
}
    public function getTotalHours(Request $request){
        $employeeName = $request->input('employeeName');
        $startDate = $request->input('start_date');
        $endDate =$request->input('end_date');
        $benefits = $request->input('benefits');
        $employeeID = Timekeeping::where('EmployeeName', $employeeName)
        ->value('EmployeeID');

        
        
        $totalHours =$this->calculateTotalHoursForDateRange($employeeName, $startDate, $endDate);
        $totalLate =$this->calculateTotalLateArrival($employeeName, $startDate, $endDate);
        $totalOvertime = $this->calculateTotalOvertime($employeeName, $startDate, $endDate);
        $rateperday = $this->GetRatePerDay($employeeID);
        $rph = $rateperday /8;
        $totalhourswithLate = $totalHours - $totalOvertime;



        

        $OTrate = ($rph * 0.30) + $rph;
        $OTpay = $OTrate * $totalOvertime;

        $salary = ($rph * $totalhourswithLate) + $OTpay + $benefits;

        $tax = $this->GetTax($salary);
        
        $totalincome = $salary - $tax;
        $timekeepingData = $this->getTimekeepingData($employeeID, $startDate, $endDate);



        if ($this->isLastWeekOfMonth($startDate) && $this->isLastWeekOfMonth($endDate)) {
           
            $totalgrossincome3weeks = $this->calculateTotalGrossByWeeks123($employeeName);


            $totallastweek = $totalgrossincome3weeks + $salary;



            $pagibig = $this->GetPagibig($totallastweek);
            $ph = $this->GetPH($totallastweek);

        } else {
            // Set default values if not the last week of the month
            $pagibig = 0;
            $ph = 0;
            $totalgrossincome3weeks = 0;
        }
        
        
        return response()->json(['totalHours' => $totalHours, 'totalLate' => $totalLate, 'employeeID' =>$employeeID,
         'totalOvertime' => $totalOvertime, 'rateperday' => $rateperday, 'salary'=> $salary, 'tax' => $tax, 'totalincome' => $totalincome, 'timekeepingData'=> $timekeepingData, 'pagibig' => $pagibig, 'ph'=> $ph, 'totalgrossincome3weeks' =>$totalgrossincome3weeks, 'totallastweek' =>$totallastweek ]);
    }
    public function calculateTotalHoursForDateRange($employeeName, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate)->endOfDay();

        
        $timekeeping = Timekeeping::where('EmployeeName', $employeeName)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalHours = 0;

        
        
        foreach ($timekeeping as $time) {
            $totalHours += $this->calculateTotalHours($time->TimeIn, $time->TimeOut);
        }
        $totalBreak = count($timekeeping); // it count 1hr break per day
        $totalHours -= $totalBreak;


        return round($totalHours, 2);
    }
  
    public function calculateTotalLateArrival($employeeName, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate, 'Asia/Manila');
        $endDate = Carbon::parse($endDate, 'Asia/Manila')->endOfDay();
    
        $timekeeping = Timekeeping::where('EmployeeName', $employeeName)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
        $totalLateMinutes = 0;
    
        foreach ($timekeeping as $time) {
    
            if ($time->LateArrival && $time->LateArrival !== '0000-00-00 00:00:00' && $time->LateArrival !== null) {
    
                $actualArrival = Carbon::parse($time->LateArrival, 'Asia/Manila');
        

                // Set the expected time on the same day as actual arrival
                $expectedTimeinOnSameDay = $actualArrival->copy()->startOfDay()->addHours(9);
    
                // Calculate the late arrival duration in minutes
                $lateArrivalDurationMinutes = max(0, $actualArrival->diffInMinutes($expectedTimeinOnSameDay));
    
                // Add the late arrival duration to the total late minutes
                $totalLateMinutes += $lateArrivalDurationMinutes;
    
            }
        }
    
        $totalLateHoursDecimal = $totalLateMinutes / 60;
    
        return round($totalLateHoursDecimal, 2);
    }
    public function calculateTotalOvertime($employeeName, $startDate, $endDate)
{
    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate)->endOfDay();

    $overtimeRecords = Timekeeping::where('EmployeeName', $employeeName)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->whereNotNull('Overtime')
        ->get();

    $totalOvertime = 0;

    foreach ($overtimeRecords as $record) {
        $totalOvertime += $record->Overtime;
    }

    return round($totalOvertime, 2);
}
    public function generatePayslip($id)
{
    $payroll = PayrollE::where('id', $id)->first();


    $pdf = PDF::loadView('payslip', compact('payroll'));

    activity()
    ->performedOn($payroll)
    ->causedBy(auth()->user())
    ->withProperties(['action' => 'payroll_generateslip'])
    ->log('Succesfully Download payslip as pdf');
    return $pdf->download('payslip.pdf');
}
public function filter(Request $request){
    $request->validate([
        'start_date' => 'required|date|before_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $start_date = $request->start_date;
    $end_date = $request->end_date;

    $payroll = PayrollE::whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->get();
        session(['filteredPayroll' => $payroll]);
    return view('reports', compact('payroll'));
}
public function filter2(Request $request){
    $request->validate([
        'start_date' => 'required|date|before_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $start_date = $request->start_date;
    $end_date = $request->end_date;

    $payroll = PayrollE::whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->get();
        session(['filteredPayroll' => $payroll]);
    return view('ownerreports', compact('payroll'));
}
public function generatesummaryreport(Request $request)
{
    // Retrieve the filtered data from session or request
    $filteredPayroll = $request->session()->get('filteredPayroll');

    // Check if there is no data
    if (empty($filteredPayroll)) {
        return redirect()->back()->with('error', 'No data found for the selected date range.');
    }

    $pdf = PDF::loadView('reportsummary', compact('filteredPayroll'));
    activity()
    ->performedOn($payroll)
    ->causedBy(auth()->user())
    ->withProperties(['action' => 'payroll_generatesummary'])
    ->log('Succesfully Download summaryreport as pdf');
    return $pdf->download('payslip.pdf');
    return $pdf->download('summaryreports.pdf');
}
public function GetRatePerDay($employeeID){

    $employee = Employees::where('EmployeeID', $employeeID)->first();



    $rpd = $employee->rate_per_day;

  
    return $rpd;

}
public function GetTax($salary){
    if ($salary <= 4808){
        $tax = 0;
    
    }
    else if ($salary > 4808 && $salary <= 7691){
        $tax = $salary * 0.15;
      
    }else if ($salary > 7691 && $salary <= 15384){
        $tax = ($salary * 0.20)+ 432.60;

        
    }
    return $tax;
}
protected function getTimekeepingData($employeeID, $startDate, $endDate)
{
    $newtime = Timekeeping::where('EmployeeID', $employeeID)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get(['created_at', 'TimeIn', 'TimeOut', 'Overtime']);

        return $newtime;


}
public function calculateTotalHoursPerDay($employeeName, $startDate, $endDate)
{
    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate)->endOfDay();

    $timekeepingRecords = Timekeeping::where('EmployeeName', $employeeName)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->whereNotNull('TimeIn')
        ->whereNotNull('TimeOut')
        ->get();

    $totalHoursPerDay = array();

    foreach ($timekeepingRecords as $record) {
        $dateKey = $record->created_at->toDateString();

        // Convert 'TimeIn' and 'TimeOut' to Carbon instances
        $timeIn = Carbon::parse($record->TimeIn);
        $timeOut = Carbon::parse($record->TimeOut);

        // Calculate the difference between TimeOut and TimeIn for each record
        $hoursDiff = $timeIn->diffInHours($timeOut);
        $minutesDiff = $timeIn->diffInMinutes($timeOut) % 60;
        $totalHours = $hoursDiff + ($minutesDiff / 60);

    
        // Accumulate total hours per day
        $totalHoursPerDay[] += $totalHours;
    }

    // Round the total hours per day to two decimal places
    foreach ($totalHoursPerDay as &$total) {
        $total = round($total, 2);
    }

    return $totalHoursPerDay;
}

public function GetPagibig($salary){

    $pagibigval = $salary * 0.02;

    return $pagibigval;
}

public function GetPH($salary){

    $ph = $salary * 0.05;

    return $ph;
}

protected function calculateTotalGrossByWeeks123($employeeName)
{
    $month = 1; // Assuming you want to calculate for the current month
    $year = date('Y');  // Assuming you want to calculate for the current year

    // Fetch gross income for week 1
    $totalGrossWeek1 = PayrollE::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->where('week_number', 1)
        ->where('employeeName', $employeeName) // Filter by employee name
        ->sum('GrossIncome');

    // Fetch gross income for week 2
    $totalGrossWeek2 = PayrollE::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->where('week_number', 2)
        ->where('employeeName', $employeeName) // Filter by employee name
        ->sum('GrossIncome');

    // Fetch gross income for week 3
    $totalGrossWeek3 = PayrollE::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->where('week_number', 3)
        ->where('employeeName', $employeeName) // Filter by employee name
        ->sum('GrossIncome');

    
        $totalGrossWeek4 = PayrollE::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->where('week_number', 4)
        ->where('employeeName', $employeeName) // Filter by employee name
        ->sum('GrossIncome');

    // Calculate the total gross income for weeks 1 to 3
    $totalGrossWeeks1to3 = $totalGrossWeek1 + $totalGrossWeek2 + $totalGrossWeek3 + $totalGrossWeek4;

    return $totalGrossWeeks1to3;
}

private function isLastWeekOfMonth($date)
{
    $carbonDate = Carbon::parse($date);
    $lastOfMonth = $carbonDate->copy()->endOfMonth();

    // Check if the given date is in the last week of the month
    $isLastWeekOfMonth = $carbonDate->diffInDays($lastOfMonth, false) < 7;

    // Check if the given date is in the first week of the month
    $isFirstWeekOfMonth = $carbonDate->day <= 7;

    return $isLastWeekOfMonth || $isFirstWeekOfMonth;
}

public function GetSSS($salary){

    
}


}