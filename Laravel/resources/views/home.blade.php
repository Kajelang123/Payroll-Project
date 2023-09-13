<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>


    <div>
        <h2>Login</h2>
        <form action ="/login" method="POST">
        @csrf
        <input name = "loginname" type ="text" placeholder ="loginname">
        <input name = "loginpassword" type ="password" placeholder ="loginpassword">
        <button>Login</button>

        
    </form>


</div>
</body>
</html>