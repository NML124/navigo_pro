<?php

$db = new PDO("mysql:host=localhost;dbname=data_users;charset=utf8", "root", "");

//On exécute une requête SQL avec query()
$sql = "SELECT * FROM operator";
$result = $db->query($sql);

//On récupère toutes les lignes avec fetchAll()
$data = $result->fetchAll();

// On convertit le tableau PHP en chaîne JSON
$json = json_encode($data);

// On affiche la chaîne JSON
echo $json;
