<?php
session_start();
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

$id = $_POST["id"];
$pin = $_POST["pin"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.hash_pin FROM person p WHERE p.id=" . $id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hash_pin = $row['hash_pin'];
    if($hash_pin == hash("sha256", $pin))
    {
        $sql = "UPDATE person SET last_login = CURRENT_TIMESTAMP WHERE id=" . $id;
        $conn->query($sql);

        $result = array('status' => 1);
        $_SESSION['ez_wko_id'] = $id;
        echo json_encode($result);
    }
    else {
        $result = array('status' => 0);
        echo json_encode($result);
    }
}
else {
    echo "0 results";
}

$conn->close();


?>
