<<?php
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data_users";

    // Connexion à la base de données en utilisant la classe PDO
    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Requête SQL pour récupérer les données de la table
    $sql = "SELECT * FROM boats";

    // Exécution de la requête SQL et récupération des résultats
    $stmt = $db->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fermeture de la connexion à la base de données
    $db = null;

    // Stockage des bateaux dans un tableau
    $boats = [];

    // Boucle pour récupérer les informations de chaque bateau
    foreach ($results as $row) {
        $url = "https://op-dev.icam.fr/~icam/" . urlencode($row["boat_name"]) . "_location.txt";
        // Lecture du contenu de l'URL
        $content = file_get_contents($url);

        // Vérifier si la récupération du contenu a réussi
        if ($content !== false) {
            // Séparation du contenu en lignes
            $lines = explode("\n", $content);

            // Stockage des lignes dans des variables distinctes
            $latitude = $lines[0];
            $longitude = $lines[1];
            $speed = $lines[2];

            // Ajout des informations du bateau dans le tableau
            $boat = array(
                "id" => $row["id"],
                "name" => $row["boat_name"],
                "latitude" => $latitude,
                "longitude" => $longitude,
                "speed" => $speed
            );
            array_push($boats, $boat);
        }
    }

    // Convertir le tableau associatif en format JSON et l'envoyer au client
    $json_data = json_encode($boats);
    header('Content-Type: application/json');
    echo $json_data;
