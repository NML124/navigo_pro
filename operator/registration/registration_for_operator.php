<?PHP
session_start();
$db = new PDO("mysql:host=localhost;dbname=data_users;charset=utf8", "root", "");
if (isset($_POST['name'], $_POST['first_name'], $_POST['user_name'], $_POST['port'], $_POST['port_address'], $_POST['password'])) {

    if (!empty($_POST['name']) and !empty($_POST['first_name']) and !empty($_POST['user_name']) and !empty($_POST['port']) and !empty($_POST['port_address']) and !empty($_POST['password'])) {

        $name = htmlspecialchars($_POST['name']);
        $first_name = htmlspecialchars($_POST['first_name']);
        $users_name = htmlspecialchars($_POST['user_name']);
        $port = htmlspecialchars($_POST['port']);
        $address = htmlspecialchars($_POST['port_address']);

        $address = urlencode($address);
        // définir le user-agent
        $userAgent = "MyGeocoderApp/1.0";
        // définir l'URL de l'API Nominatim
        $url = "http://nominatim.openstreetmap.org/?format=json&addressdetails=1&q={$address}&format=json&limit=1";
        // créer un contexte HTTP avec le user-agent
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "User-Agent: {$userAgent}\r\n"
            )
        ));
        // obtenir la réponse JSON
        $resp_json = file_get_contents($url, false, $context);
        // décoder le JSON
        $resp = json_decode($resp_json, true);
        // vérifier si le JSON est valide
        if ($resp && isset($resp[0])) {
            // récupérer la latitude et la longitude
            $lat = $resp[0]['lat'];
            $lng = $resp[0]['lon'];
        } else {
            // afficher une erreur
            echo "Erreur: impossible de géocoder l'adresse\n";
        }

        $password = htmlspecialchars($_POST['password']);
        $passwordHash = sha1($password);

        $insert = $db->prepare("INSERT INTO operator(name, first_name, user_name, port, address, longitude, latitude, passwords) VALUES(?,?,?,?,?,?,?,?)");
        $insert->execute(array($name, $first_name, $users_name, $port, $address, $lng, $lat, $passwordHash));

        $_SESSION['user_data'] = array(
            'name' => $name,
            'first_name' => $first_name,
            'user_name' => $users_name,
            'port' => $port,
            'address' => $address,
            'longitude' => $lng,
            'latitude' => $lat,
            'passwords' => $passwordHash
        );


        $port_db_name = str_replace(' ', '_', $port);
        $servername = 'localhost';
        $username = 'root';
        $password = '';

        try {
            $dbco = new PDO("mysql:host=$servername", $username, $password);
            $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE DATABASE $port_db_name";
            $dbco->exec($sql);

            $db_port  = new PDO("mysql:host=localhost;dbname=$port_db_name;charset=utf8", "root", "");
            $db_port->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql1 = "CREATE TABLE agent (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                first_name VARCHAR(30) NOT NULL,
                user_name VARCHAR(30) NOT NULL,
                email VARCHAR(50) NOT NULL,
                matricule VARCHAR(30) NOT NULL 
            )";
            $db_port->exec($sql1);


            // La requête SQL pour créer la table
            $sql2 = "CREATE TABLE fishing_boat (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                immatriculation VARCHAR(10) NOT NULL,
                captain VARCHAR(30) NOT NULL,
                crew INT NOT NULL,
                quantity DECIMAL(10,2) NOT NULL,
                type VARCHAR(20) NOT NULL,
                location VARCHAR(50) NOT NULL,
                duration INT NOT NULL,
                departure_date DATE NOT NULL,
                departure_time TIME NOT NULL,
                arrival_date  DATE NOT NULL,
                arrival_time TIME NOT NULL,
                agent VARCHAR(30) NOT NULL
            )";

            // Exécution de la requête
            $db_port->exec($sql2);
            // La requête SQL pour créer la table cargot_boat
            $sql3 = "CREATE TABLE cargot_boat (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                immatriculation VARCHAR(10) NOT NULL,
                captain VARCHAR(30) NOT NULL,
                crew INT NOT NULL,
                nature VARCHAR(50) NOT NULL,
                weight DECIMAL(10,2) NOT NULL,
                departure_port VARCHAR(50) NOT NULL,
                destination_port VARCHAR(50) NOT NULL,
                departure_date DATE NOT NULL,
                departure_time TIME NOT NULL,
                arrival_date  DATE NOT NULL,
                arrival_time TIME NOT NULL,
                agent VARCHAR(30) NOT NULL
            )";

            // Exécution de la requête
            $db_port->exec($sql3);
            // La requête SQL pour créer la table pleasure_boat
            $sql4 = "CREATE TABLE pleasure_boat (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                immatriculation VARCHAR(10) NOT NULL,
                owner VARCHAR(30) NOT NULL,
                passenger_numbers INT NOT NULL,
                duration INT NOT NULL,
                motif VARCHAR(50) NOT NULL,
                agent VARCHAR(30) NOT NULL
            )";
            // Exécution de la requête
            $db_port->exec($sql4);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        header('Location:/operator/ship_traffic_controller/index.html');
        exit();
    } else {
        $validation = "There is an error please try again later";
    }
}
