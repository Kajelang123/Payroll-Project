<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Slip</title>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .payroll-details {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
        }

        .payroll-details p {
            margin: 8px 0;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Payroll Slip</h1>
    
    <div class="payroll-details">
        <p><strong>Date:</strong> {{ $payroll->created_at->format('Y-m-d') }}</p>
        <p><strong>Employee ID:</strong> {{ $payroll->EmployeeID }}</p>
        <p><strong>Employee Name:</strong> {{ $payroll->EmployeeName }}</p>
        <p><strong>Salary:</strong> Php{{ $payroll->Salary }}</p>
        <p><strong>GrossIncome:</strong> Php{{ $payroll->GrossIncome }}</p>
        <p><strong>------------------------------------------------------------------------------------------------------------------------</strong></p>
        <p><strong>Deductions:</strong></p><br>
        <p><strong>SSS:</strong> Php{{ $payroll->SSS }}</p>
        <p><strong>PHILHEALTH:</strong> Php{{ $payroll->PHILHEALTH }}</p>
        <p><strong>PAGIBIG:</strong> Php{{ $payroll->PAGIBIG }}</p>
        <p><strong>-------------------------------------------------------------------------------------------------------------------------</strong></p>
        <p><strong>Total Deduction:</strong> Php{{ $payroll->TotalDeduction }}</p>
        <p><strong>NetIncome:</strong> Php{{ $payroll->NetIncome }}</p>
    </div>
    
    <div class="footer">
        <p><em>Generated on: {{ now() }}</em></p>
    </div>
</body>
</html>
