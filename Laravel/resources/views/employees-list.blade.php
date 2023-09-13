<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Payroll System</title>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Payroll System</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="/dashboard">Home</a></li>
                <li><a href="/employees">User Management</a></li>
                <li><a href="#">Payroll</a></li>
                <li><a href="#">Reports</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top:20px">
        <div class="row">
            <h2>Employees List</h2>
            <div style="float: right"><a href="{{url('addemployees')}}"><button type="button" class="btn btn-info">Add</button></a>
                
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee id</th>
                        <th>FirstName</th>
                        <th>MiddleName</th>
                        <th>LastName</th>
                        <th>Email</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($employees as $emp)
                  <tr>
                      <td>{{ $emp->id }}</td>
                      <td>{{ $emp->FirstName }}</td>
                      <td>{{ $emp->MiddleName }}</td>
                      <td>{{ $emp->LastName }}</td>
                      <td>{{ $emp->Email }}</td>
                      <td>{{ $emp->Position }}</td>
                      <td>
                        <a href="{{url('edit-employees/'. $emp->id)}}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                    <td>
                        <a href="" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                  </tr>
              @endforeach
                  
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>