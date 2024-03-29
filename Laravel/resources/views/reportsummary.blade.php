<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Summary</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Payroll Summary</h1>

        <table class="table table-striped">
            <thead style="background-color: #f5f5f5; color: #333;">
                <tr>
                    <th>Date</th>
                    <th>EmployeeID</th>
                    <th>EmployeeName</th>
                    <th>Salary</th>
                    <th>Rate Per Hour</th>
                    <th>Total Work Hours</th>
                    <th>Gross Income</th>
                    <th>Total Deductions</th>
                    <th>NetIncome</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredPayroll as $pay)
                    <tr>
                        <td>{{ $pay->created_at->format('Y-m-d') }}</td>
                        <td>{{ $pay->EmployeeID }}</td>
                        <td>{{ $pay->EmployeeName }}</td>
                        <td>{{ "Php" .$pay->Salary  }}</td>
                        <td>{{ $pay->RPH }}</td>
                        <td>{{ $pay->TotalHrs }}</td>
                        <td>{{ $pay->GrossIncome }}</td>
                        <td>{{ $pay->TotalDeduction }}</td>
                        <td>{{ $pay->NetIncome }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
