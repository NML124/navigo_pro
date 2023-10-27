<?php
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
if (isset($_POST['name'], $_POST['immatriculation'], $_POST['captain'], $_POST['crew'], $_POST['nature'], $_POST['weight'], $_POST['departure_port'], $_POST['destination_port'], $_POST['departure_date'], $_POST['departure_time'], $_POST['arrival_date'], $_POST['arrival_time'])) {
    if (!empty($_POST['name']) and !empty($_POST['immatriculation']) and !empty($_POST['captain']) and !empty($_POST['crew']) and !empty($_POST['nature']) and !empty($_POST['weight']) and !empty($_POST['departure_port']) and !empty($_POST['destination_port']) and !empty($_POST['departure_date']) and !empty($_POST['departure_time']) and !empty($_POST['arrival_date']) and !empty($_POST['arrival_time'])) {

        // Récupération des données du formulaire
        $name = htmlspecialchars($_POST['name']);
        $immatriculation = htmlspecialchars($_POST['immatriculation']);
        $captain = htmlspecialchars($_POST['captain']);
        $crew = htmlspecialchars($_POST['crew']);
        $nature = htmlspecialchars($_POST['nature']);
        $weight = htmlspecialchars($_POST['weight']);
        $departure_port = htmlspecialchars($_POST['departure_port']);
        $destination_port = htmlspecialchars($_POST['destination_port']);
        $departure_date = htmlspecialchars($_POST['departure_date']);
        $departure_time = htmlspecialchars($_POST['departure_time']);
        $arrival_date = htmlspecialchars($_POST['arrival_date']);
        $arrival_time = htmlspecialchars($_POST['arrival_time']);
        $agent = $full_name;
        $sql = "INSERT INTO cargo_boat (name, immatriculation, captain, crew, nature, weight, departure_port, destination_port, departure_date, departure_time, arrival_date, arrival_time, agent) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $insert = $db->prepare($sql);
        $insert->execute(array($name, $immatriculation, $captain, $crew, $nature, $weight, $departure_port, $destination_port, $departure_date, $departure_time, $arrival_date, $arrival_time, $agent));
    }
}
// Fermeture de la connexion à la base de données
$db = null;
