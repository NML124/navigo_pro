<?PHP
session_start();
$port = null;
if (isset($_SESSION['user_data'])) {
    // Récupérer les données de la session
    $name = $_SESSION['user_data']['name'];
    $first_name = $_SESSION['user_data']['first_name'];
    $user_name = $_SESSION['user_data']['user_name'];
    $email = $_SESSION['user_data']['email'];
    $port_session = $_SESSION['user_data']['port'];
    $matricule = $_SESSION['user_data']['matricule'];
    $port = str_replace(' ', '_', $port_session);

    $full_name = $name . " " . $first_name;
} else {
    // Afficher un message d'erreur
    echo 'Les données de la session sont introuvables';
}

$db = new PDO("mysql:host=localhost;dbname=$port;charset=utf8", "root", "");

if (isset($_POST['name'], $_POST['immatriculation'], $_POST['owner'], $_POST['passenger_numbers'], $_POST['duration'], $_POST['motif'])) {

    if (!empty($_POST['name']) and !empty($_POST['immatriculation']) and !empty($_POST['owner']) and !empty($_POST['passenger_numbers']) and !empty($_POST['duration']) and !empty($_POST['motif'])) {

        $name = htmlspecialchars($_POST['name']);
        $immatriculation = htmlspecialchars($_POST['immatriculation']);
        $owner = htmlspecialchars($_POST['owner']);
        $passenger_numbers = htmlspecialchars($_POST['passenger_numbers']);
        $duration = htmlspecialchars($_POST['duration']);
        $motif = htmlspecialchars($_POST['motif']);

        $insert = $db->prepare("INSERT INTO pleasure_boat(name, immatriculation, owner, passenger_numbers, duration, motif, agent) VALUES(?,?,?,?,?,?,?)");
        $insert->execute(array($name, $immatriculation, $owner, $passenger_numbers, $duration, $motif, $full_name));

        header("location:/agent/port_manage/home.php");
        exit();
    } else {
        $validation = "There is an error please try again later";
        echo $validation;
    }
}
