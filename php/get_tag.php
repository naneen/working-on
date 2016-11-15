<?php
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

$sql = "SELECT t.tag_name, t.last_use FROM tag t ORDER BY t.last_use DESC";
$result = $conn->query($sql);

$tags = array();
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		array_push($tags, $row['tag_name']);
	}
}


$response = array("result"=>1,"tags"=>$tags);
echo json_encode($response);
