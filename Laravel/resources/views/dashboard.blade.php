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
          <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li class="active"><a href="/">User Management</a></li>
            <li><a href="#">Payroll</a></li>
            <li><a href="#">Reports</a></li>
          </ul>
        </div>
      </nav>
      <div>
       
        <form action ="/" method="POST">
        
        <input name = "LastName" type ="textarea" placeholder ="LastName"> <br>
        <input name = "FirstName" type ="textarea" placeholder ="FirstName"> <br>
        <input name = "MiddleName" type ="textarea" placeholder ="MiddleName"> <br>
        <input name = "Contact Information" type ="textarea" placeholder ="Contact No."> <br>
        

        <button>Add</button>

        
    </form>
</body>
</html>