<?php
session_start();
// Vérifier si les données de la session existent
if (isset($_SESSION['user_data'])) {
    // Récupérer les données de la session
    $name = $_SESSION['user_data']['name'];
    $first_name = $_SESSION['user_data']['first_name'];
    $user_name = $_SESSION['user_data']['user_name'];
    $address = $_SESSION['user_data']['address'];
    $boat_name = $_SESSION['user_data']['boat_name'];

    $address_decode = urldecode($address);

    // Créer un tableau associatif avec les données
    $params = [
        'name' => $name,
        'first_name' => $first_name,
        'user_name' => $user_name,
        'address' => $address_decode,
        'boat_name' => $boat_name
    ];
} 
// Récupère le contenu du fichier boatproject4.txt à partir de l'URL
$file_url = "https://op-dev.icam.fr/~icam/".$boat_name."_control.txt";
$file_contents = file_get_contents($file_url);

// Sépare le contenu du fichier en lignes
$file_lines = explode("\n", $file_contents);

// Récupère les coordonnées et l'action à partir des lignes du fichier
$line1 = $file_lines[0];
$line2 = $file_lines[1];
$line3 = $file_lines[2];

// Affiche les coordonnées et l'action
/*
echo "speed : " . $speed . "<br>";
echo "Direction : " . $direction . "<br>";
echo "Action : " . $action . "<br>";
*/

$data = array("accelero" => $line1, "gyro" => $line2, "gps" => $line3);
echo json_encode($data);
