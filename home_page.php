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
            <h1>Who are you ?</h1>
            <input type="radio" name="choice" value="operator" id="operator">
            <label for="operator" id="operator_label">Operator</label>

            <input type="radio" name="choice" value="captain" id="captain">
            <label for="captain" id="captain_label">Captain</label>

            <input type="radio" name="choice" value="agent" id="agent">
            <label for="agent" id="agent_label">Agent</label>

            <input type="submit" id='submit' value='SUBMIT'>
            <a href="/authentification/login.php" id="link">login</a>
        </form>
        <?php
        if (isset($_POST['choice'])) {
            $choice = $_POST['choice'];

            if ($choice == 'operator') {
                header('Location:operator/registration/sign_in_operator.html');
                exit();
            } elseif ($choice == 'captain') {
                header('Location:captain/registration/sign_in_captain.html');
                exit();
            } elseif ($choice == 'agent') {
                header('Location:agent/registration/sign_in_agent.html');
                exit();
            }
        }
        ?>
    </div>
</body>

</html>