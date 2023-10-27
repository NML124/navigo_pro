<?php
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

    // Créer un tableau associatif avec les données
    $params = [
        'name' => $name,
        'first_name' => $first_name,
        'user_name' => $user_name,
        'port' => $port,
        'address' => $address_decode,
        'lng' => $lng,
        'lat' => $lat,
    ];

    // Encoder le tableau en JSON
    $json_data = json_encode($params);

    // Modifier le type MIME de la réponse en application/json
    header("Content-Type: application/json");

    // Afficher les données JSON
    echo $json_data;
} else {
    // Afficher un message d'erreur
    echo 'Les données de la session sont introuvables';
}
