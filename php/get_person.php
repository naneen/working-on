<?php

session_start();

$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM person WHERE status = 1";

$result = $conn->query($sql);


$conn->close();

$persons = array();

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		array_push($persons, $row);
	}
}

$_SESSION["people"] = $persons;


$response = array("result"=>1,"persons"=>$persons);
echo json_encode($response);
?>
