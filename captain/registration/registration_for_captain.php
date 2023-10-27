<?PHP
session_start();
$db = new PDO("mysql:host=localhost;dbname=data_users;charset=utf8", "root", "");


if (isset($_POST['name'], $_POST['first_name'], $_POST['user_name'], $_POST['nationality'], $_POST['address'], $_POST['phone_number'], $_POST['date'], $_POST['place_birth'], $_POST['email'], $_POST['password'], $_POST['boat_name'], $_POST['boat_length'], $_POST['boat_type'], $_POST['engine_power'])) {

    if (!empty($_POST['name']) and !empty($_POST['first_name']) and !empty($_POST['user_name']) and !empty($_POST['nationality']) and !empty($_POST['address']) and !empty($_POST['phone_number']) and !empty($_POST['date']) and !empty($_POST['place_birth']) and !empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['boat_name']) and !empty($_POST['boat_length']) and !empty($_POST['boat_type']) and !empty($_POST['engine_power'])) {
        /*For a person in charge*/
        $name = htmlspecialchars($_POST['name']);
        $first_name = htmlspecialchars($_POST['first_name']);
        $users_name = htmlspecialchars($_POST['user_name']);
        $nationality = htmlspecialchars($_POST['nationality']);
        $address = htmlspecialchars($_POST['address']);
        $phone_number = htmlspecialchars($_POST['phone_number']);
        $date = htmlspecialchars($_POST['date']);
        $place_birth = htmlspecialchars($_POST['place_birth']);
        $email = htmlspecialchars($_POST['email']);

        $password = htmlspecialchars($_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        /*For a boat*/
        $boat_name = htmlspecialchars($_POST['boat_name']);
        $boat_length = htmlspecialchars($_POST['boat_length']);
        $boat_type = htmlspecialchars($_POST['boat_type']);
        $engine_power = htmlspecialchars($_POST['engine_power']);
        $lat = 0.0;
        $lon = 0.0;
        $speed = 0.0;

        $boat_name_db = str_replace(' ', '_', $boat_name);
        $url = "https://op-dev.icam.fr/~icam/recordLocation.php?fileName=" . $boat_name_db . "_other.txt&lat=" . $lat . "&lon=" . $lon . "0&action=" . $speed;
        $url2 = "https://op-dev.icam.fr/~icam/recordLocation.php?fileName=" . $boat_name_db . "_control.txt&lat=" . $lat . "&lon=" . $lon . "0&action=" . $speed;
        $json = file_get_contents($url);
        $json2 = file_get_contents($url2);

        $insert = $db->prepare("INSERT INTO captain(name, first_name, user_name, nationality, address, phone_number, date, place_birth, email, password) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $insert->execute(array($name, $first_name, $users_name, $nationality, $address, $phone_number, $date, $place_birth, $email, $passwordHash));

        $insert_boat = $db->prepare("INSERT INTO boat(boat_name, boat_length, boat_type, engine_power, latitude, longitude, speed) VALUES(?,?,?,?,?,?,?)");
        $insert_boat->execute(array($boat_name, $boat_length, $boat_type, $engine_power, $lat, $lon, $speed));

        $_SESSION['user_data'] = array(
            'name' => $name,
            'first_name' => $first_name,
            'user_name' => $users_name,
            'address' => $address,
            'boat_name' => $boat_name
        );

        header('Location:operator/ship_controller');
    } else {
        $validation = "There is an error please try again later";
    }
}
