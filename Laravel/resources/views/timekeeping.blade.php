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
        </div>
    </nav>
    
    <div class="container">
        <form method="post" action="{{ url('/') }}">
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
            @if(Session::has('failed'))
            <div class="alert alert-danger" role="alert">
                {{Session::get('failed')}}
            </div>
            @endif
            @csrf
            <label class="form-label">Scan your RFID</label>
            <input type="text" class="form-control" name="rfid" placeholder="Scan Your RFID">
            <button type="submit">Submit</button>
        </form>

    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <br>
    <br>
    <br>
    <br>
    

    <div class ="container">
    <table class="table">
        <thead>
            <tr>
                <th>EmployeeID</th>
                <th>EmployeeName</th>
                <th>TimeIn</th>
                <th>TimeOut</th>
            
                
                
            </tr>
        </thead>
        <tbody>
          @foreach ($timekeeping as $time)
          <tr>
              <td>{{ $time->EmployeeID }}</td>
              <td>{{ $time->EmployeeName }}</td>
              <td>{{ $time->TimeIn }}</td>
              <td>{{ $time->TimeOut }}</td>

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
</div>

</body>
</html>
