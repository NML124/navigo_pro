<?php
// Récupération du nom de la base de données depuis la session de l'utilisateur
session_start();
// Vérifier si les données de la session existent
if (isset($_SESSION['user_data'])) {
    // Récupérer les données de la session
    $name = $_SESSION['user_data']['name'];
    $first_name = $_SESSION['user_data']['first_name'];
    $user_name = $_SESSION['user_data']['user_name'];
    $port = $_SESSION['user_data']['port'];
    $address = $_SESSION['user_data']['address'];
    $lng = $_SESSION['user_data']['longitude'];
    $lat = $_SESSION['user_data']['latitude'];

    $address_decode = urldecode($address);
} else {
    // Afficher un message d'erreur
    echo 'Les données de la session sont introuvables';
}


// Connexion à la base de données
$servername = "localhost";
$username = "username";
$password = "password";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données $port";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Récupération des données de la table "agent"
$stmt = $conn->prepare("SELECT * FROM agents");
$stmt->execute();
$agent = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des données de la table "cargot_boat"
$stmt = $conn->prepare("SELECT * FROM cargot_boat");
$stmt->execute();
$cargot = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des données de la table "fishing_boat"
$stmt = $conn->prepare("SELECT * FROM fishing_boat");
$stmt->execute();
$fiching = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des données de la table "pleasure_boat"
$stmt = $conn->prepare("SELECT * FROM pleasure_boat");
$stmt->execute();
$pleasure = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fermeture de la connexion à la base de données
$conn = null;

// Affichage des données récupérées
echo "<pre>";
print_r($agent);
print_r($cargot);
print_r($fishing);
print_r($pleasure);
echo "</pre>";
