<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- import style file -->
    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="/img/Flaticon.png" />
    <title>Sign Up</title>
</head>

<body id="BODY">
    <div id="container">
        <form method="POST" action="">
            <h1>Which boat arrived in port ?</h1>
            <input type="radio" name="choice" value="fishing_boat" id="fishing_boat">
            <label for="fishing_boat" id="fishing_boat_label">fishing boat</label> <br>

            <input type="radio" name="choice" value="cargot_boat" id="cargot_boat">
            <label for="cargot_boat" id="cargot_boat_label">cargot boat</label> <br>

            <input type="radio" name="choice" value="pleasure_boat" id="pleasure_boat">
            <label for="pleasure_boat" id="pleasure_boat_label">pleasure boat</label> <br>

            <input type="submit" id='submit' value='Register'>
        </form>
        <?php
        if (isset($_POST['choice'])) {
            $choice = $_POST['choice'];

            if ($choice == 'fishing_boat') {
                header('Location:./manage/fishing_boat.html');
                exit();
            } elseif ($choice == 'cargot_boat') {
                header('Location:./manage/cargot_boat.html');
                exit();
            } elseif ($choice == 'pleasure_boat') {
                header('Location:./manage/pleasure_boat.html');
                exit();
            }
        }
        ?>
    </div>
</body>

</html>