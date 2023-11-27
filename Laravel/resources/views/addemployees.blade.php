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
                <li><a href="#">User Management</a></li>
                <li><a href="/employees">Employees Management</a></li>
                <li><a href="#">Payroll</a></li>
                <li><a href="#">Reports</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top:30px"> 
        <div class="row">
            <div class="col-md-12">
                <h2>Add Employee</h2>
                @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @endif
                <form method="post" action="{{url('save-employee')}}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Enter your First Name" value = {{old('first_name')}}>
        
                        @error('first_name')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" placeholder="Enter your Middle Name">
                        @error('middle_name')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Enter your Last Name">
                        @error('last_name')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="Email" placeholder="Enter your Email">
                        @error('Email')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dropdown">Department</label>
                        <select id="dropdown" name="Department">
                                <option>Accounting Department</option>
                                <option>Purchasing Department</option>
                                <option>Graphic Artist Department</option>
                                <option>Production Department</option>
                        
                        </select>
                        @error('Department')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dropdown">Job Position</label>
                        <select id="dropdown" name="position">
                                <option>Accounting Officer</option>
                                <option>Accounting Manager</option>
                                <option>Graphic Artist</option>
                                <option>Installers</option>
                                <option>Painter</option>
                                <option>Printing</option>
                                <option>Lamination</option>
                                <option>Lighting</option>
                        
                        </select>
                        @error('Department')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact No.</label>
                        <input type="text" class="form-control" name="Contact" placeholder="Enter your Contact No.">
                        @error('Contact')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">RFID</label>
                        <input type="text" class="form-control" name="EmployeeID" placeholder="Scan your RFID">
                        @error('RFID')
                        <div class="alert alert-warning" role="alert">
                            {{$message}}
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>

                    <a href="{{url('employees')}}" class="btn btn-danger">Cancel</a>

                    
                </form>

            </div>
    </div>
    
</body>
</html>
