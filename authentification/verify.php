<?PHP

session_start();
$db = new PDO("mysql:host=localhost;dbname=data_users;charset=utf8", "root", "");
if (isset($_POST['submit'])) {
    if (!empty($_POST['user_name'] and !empty($_POST['password'] and !empty($_POST['user_type'])))) {

        $user_name = htmlspecialchars($_POST['user_name']);
        $password = sha1($_POST['password']);
        $user_type = $_POST['user_type'];

        if ($user_type == '1') {
            $recup_user = $db->prepare('SELECT * FROM operator WHERE user_name = ? AND passwords = ?');
            $recup_user->execute(array($user_name, $password));

            if ($recup_user->rowCount() > 0) {
                // Récupérer toutes les données de l'utilisateur dans un tableau associatif
                $user_data = $recup_user->fetch();
                // Stocker les données dans la variable de session
                $_SESSION['user_data'] = $user_data;
                // Rediriger l'utilisateur vers la page protégée
                header('Location:/operator/ship_traffic_controller/index.html');
                exit();
            } else {
                header('Location:./login.php');
                exit();
            }
        }
        if ($user_type == '2') {
            $recupUser = $db->prepare('SELECT * FROM captain WHERE user_name = ? AND password = ?');
            $recupUser->execute(array($user_name, $password));

            if ($recupUser->rowCount() > 0) {
                // Récupérer toutes les données de l'utilisateur dans un tableau associatif
                $user_data = $recupUser->fetch();
                // Stocker les données dans la variable de session
                $_SESSION['user_data'] = $user_data;
                // Rediriger l'utilisateur vers la page protégée
                header('Location:/captain/ship_controller/index.html');
                exit();
            } else {
                header('Location:./login.php');
                exit();
            }
        }
        if ($user_type == '3') {
            $recup_user_agent = $db->prepare('SELECT * FROM agent WHERE user_name = ? AND passwords = ?');
            $recup_user_agent->execute(array($user_name, $password));

            if ($recup_user_agent->rowCount() > 0) {
                // Récupérer toutes les données de l'utilisateur dans un tableau associatif
                $user_data = $recup_user_agent->fetch();
                // Stocker les données dans la variable de session
                $_SESSION['user_data'] = $user_data;
                // Rediriger l'utilisateur vers la page protégée
                header('Location:/agent/port_manage/home.php');
                exit();
            } else {
                header('Location:./login.php');
                exit();
            }
        }
    } else {
        $validation = "There is an error please try again later";
    }
}
