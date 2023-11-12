<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Home</title>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Payroll System</a>
          </div>
      </nav>
    </div>
       
    <form method="post" action="{{url('/')}}">
        @csrf
        <div class="container" style="align-items: center">
    
            <label class="form-label">Scan your RFID</label>
            <input type="text" class="form-control" name="scan" placeholder="Scan Your RFID">
        
        </div>
        
    </form>
</body>
</html>