<?php
session_start();
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

$id = $_SESSION['ez_wko_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE activity SET end_time = CURRENT_TIMESTAMP WHERE ISNULL(end_time) AND owner_id = " . $id;
$result = $conn->query($sql);

$conn->close();

$result = array('status' => 1);
echo json_encode($result);
?>
