<?PHP
session_start();
$db = new PDO("mysql:host=localhost;dbname=data_users;charset=utf8", "root", "");
if (isset($_POST['name'], $_POST['first_name'], $_POST['user_name'], $_POST['email'], $_POST['matricule'], $_POST['port'], $_POST['password'])) {

    if (!empty($_POST['name']) and !empty($_POST['first_name']) and !empty($_POST['user_name']) and !empty($_POST['email']) and !empty($_POST['matricule']) and !empty($_POST['port']) and !empty($_POST['password'])) {

        $name = htmlspecialchars($_POST['name']);
        $first_name = htmlspecialchars($_POST['first_name']);
        $user_name = htmlspecialchars($_POST['user_name']);
        $email = htmlspecialchars($_POST['email']);
        $matricule = htmlspecialchars($_POST['matricule']);
        $port = htmlspecialchars($_POST['port']);
        $port_db = str_replace(' ', '_', $port);

        $password = htmlspecialchars($_POST['password']);
        $passwordHash = sha1($password);


        try {
            $servername = "localhost";
            $username = "root";
            $db_password = "";

            // Créer une connexion
            $conn = mysqli_connect($servername, $username, $db_password);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (mysqli_select_db($conn, $port_db)) {

                $insert = $db->prepare("INSERT INTO agent(name, first_name, user_name, email, matricule, port, passwords) VALUES(?,?,?,?,?,?,?)");
                $insert->execute(array($name, $first_name, $user_name, $email, $matricule, $port, $passwordHash));


                $db2 = new PDO("mysql:host=localhost;dbname=$port_db;charset=utf8", "root", "");
                $insert2 = $db2->prepare("INSERT INTO agent(name, first_name, user_name, email, matricule) VALUES(?,?,?,?,?)");
                $insert2->execute(array($name, $first_name, $user_name, $email, $matricule));


                $_SESSION['user_data'] = array(
                    'name' => $name,
                    'first_name' => $first_name,
                    'user_name' => $user_name,
                    'email' => $email,
                    'port' => $port,
                    'matricule' => $matricule,
                    'passwords' => $passwordHash
                );

                header('Location:/agent/port_manage/home.php');
                exit();
            } else {
                // La base de données n'existe pas
                echo "This port doesn't exist";
            }
        } catch (PDOException $e) {
            // Affichage de l'erreur en cas d'échec
            echo "Error : " . $e->getMessage();
        }
    } else {
        $validation = "There is an error please try again later";
    }
}
