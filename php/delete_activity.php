
<?php
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";
$id = $_POST['id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE activity SET activity.delete = 1 WHERE id = " . $id;
$result = $conn->query($sql);

$conn->close();

$result = array('status' => 1);
echo json_encode($result);
?>
