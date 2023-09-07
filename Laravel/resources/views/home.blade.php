<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

    @auth
    <p>Hello! Welcome</p>
    <form action ="/logout" method="POST">
        @csrf
        <button>Logout</button>
    @else
    <div>
        <h2>Registration Form</h2>
        <form action ="/register" method="POST">
        @csrf
        <input name = "name" type ="text" placeholder ="name">
        <input name = "email" type ="text" placeholder ="email">
        <input name = "password" type ="password" placeholder ="password">
        <button>Register</button>


    </form>

    <div>
        <h2>Login</h2>
        <form action ="/login" method="POST">
        @csrf
        <input name = "loginname" type ="text" placeholder ="loginname">
        <input name = "loginpassword" type ="password" placeholder ="loginpassword">
        <button>Login</button>

        
    </form>


    @endauth
</div>
</body>
</html>