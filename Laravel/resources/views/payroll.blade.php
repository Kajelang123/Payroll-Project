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
            <li><a href="/payroll">Payroll</a></li>
            <li><a href="#">Reports</a></li>
          </ul>
        </div>
    </nav>
    
    <div class="container" style="margin-top:20px">
        <div class="row">
            <div style="float: right">
                <!-- Add data-toggle and data-target attributes to open the modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                    Add
                </button>
            </div>
            <h2>Payroll</h2>

            <table class="table">
                <thead>
                    <tr>
                        <th>iD</th>
                        <th>EmployeeName</th>
                        <th>Salary</th>
                        <th>Rate Per Hour</th>
                        <th>Total Work Hours</th>
                        <th>Deduction</th>
                        <th>Benefits</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                  @foreach ($payroll as $pay)
                  <tr>
                      <td>{{ $pay->id }}</td>
                      <td>{{ $pay->EmployeeName }}</td>
                      <td>{{ $pay->Salary }}</td>
                      <td>{{ $pay->RPH }}</td>
                      <td>{{ $pay->TotalHrs }}</td>
                      <td>{{ $pay->SSS }}</td>
                      <td>{{ $pay->Benefits }}</td>
                      <td>
                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                  </tr>
              @endforeach
                  
                </tbody>
            </table>
        </div>
    </div>
        </div>
    
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content -->
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Employee Payroll</h4>
                    </div>
    
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ route('save-payroll') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="dropdown">Employee Name</label>
                                <select id="dropdown" name="employeeName">
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->FirstName . ' ' . $emp->MiddleName . ' ' . $emp->LastName }}">
                                            {{ $emp->FirstName . ' ' . $emp->MiddleName . ' ' . $emp->LastName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employeeName')
                                    <div class="alert alert-warning" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Rate Per Hour</label>
                                <input type="text" class="form-control" name="rph" placeholder="Enter Rate Per Hour" value="{{ old('rph') }}">
                                @error('rph')
                                    <div class="alert alert-warning" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Salary</label>
                                <input type="text" class="form-control" name="salary" placeholder="Enter Salary" value="{{ old('salary') }}">
                                @error('salary')
                                    <div class="alert alert-warning" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Work Hours</label>
                                <input type="text" class="form-control" name="twh" placeholder="Enter the Total Work Hours" value="{{ old('twh') }}">
                                @error('twh')
                                    <div class="alert alert-warning" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deduction</label>
                                <input type="text" class="form-control" name="deduction" value="900" readonly>
                                @error('deduction')
                                    <div class="alert alert-warning" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Benefits</label>
                                <input type="text" class="form-control" name="benefits" placeholder="Enter Benefits" value="{{ old('benefits') }}">
                                @error('benefits')
                                    <div class="alert alert-warning" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    
    
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    
</body>
</html>
