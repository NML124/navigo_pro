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
if (isset($_POST['name'], $_POST['immatriculation'], $_POST['captain'], $_POST['crew'], $_POST['quantity'], $_POST['type'], $_POST['location'], $_POST['duration'], $_POST['departure_date'], $_POST['departure_time'], $_POST['arrival_date'], $_POST['arrival_time'])) {
    if (!empty($_POST['name']) and !empty($_POST['immatriculation']) and !empty($_POST['captain']) and !empty($_POST['crew']) and !empty($_POST['quantity']) and !empty($_POST['type']) and !empty($_POST['location']) and !empty($_POST['duration']) and !empty($_POST['departure_date']) and !empty($_POST['departure_time']) and !empty($_POST['arrival_date']) and !empty($_POST['arrival_time'])) {

        // Récupération de l'agent à partir des données de session
        $agent = $full_name;

        // Récupération des données soumises par le formulaire
        $name = htmlspecialchars($_POST['name']);
        $immatriculation = htmlspecialchars($_POST['immatriculation']);
        $captain = htmlspecialchars($_POST['captain']);
        $crew = htmlspecialchars($_POST['crew']);
        $quantity = htmlspecialchars($_POST['quantity']);
        $type = htmlspecialchars($_POST['type']);
        $location = htmlspecialchars($_POST['location']);
        $duration = htmlspecialchars($_POST['duration']);
        $departure_date = htmlspecialchars($_POST['departure_date']);
        $departure_time = htmlspecialchars($_POST['departure_time']);
        $arrival_date = htmlspecialchars($_POST['arrival_date']);
        $arrival_time = htmlspecialchars($_POST['arrival_time']);

        // Insertion des données dans la base de données
        $sql = "INSERT INTO nom_de_la_table (name, immatriculation, captain, crew, quantity, type, location, duration, departure_date, departure_time, arrival_date, arrival_time, agent) VALUES ('$name', '$immatriculation', '$captain', '$crew', '$quantity', '$type', '$location', '$duration', '$departure_date', '$departure_time', '$arrival_date', '$arrival_time', '$full_name')";
        $db->exec($sql); // Exécution de la requête SQL

        header("location:/agent/port_manage/home.php");
        exit();
    } else {
        $validation = "There is an error please try again later";
        echo $validation;
    }
}

// Fermeture de la connexion à la base de données
$db = null;
