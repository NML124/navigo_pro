<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- import style file -->
    <link rel="stylesheet" href="/style.css" media="screen" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="/img/Flaticon.png" />
    <title>Login</title>
</head>

<body id="BODY">
    <div id="container">
        <!-- registration area -->

        <form action="verify.php" method="POST">
            <h1>Login</h1>

            <label><b>User name</b></label>
            <input type="text" placeholder="Enter the user name" name="user_name" required>

            <label><b>Who are you ?</b></label><br>
            <select name="user_type" id="user_type">
                <option value="1">Operator</option>
                <option value="2">Captain</option>
                <option value="3">Agent</option>
            </select><br>

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter the password" name="password" required>

            <input type="submit" id='submit' name='submit' value='SUBMIT'>
            <a href="/home_page.php" id="link">Sign in</a>
        </form>
    </div>
</body>

</html>