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

$sql = "SELECT * FROM tag t WHERE t.tag_name = '" . $_POST["tag"] . "'";
$result = $conn->query($sql);

$tags = array();
$row = $result->fetch_assoc();

$row['created_time'] = ($row["created_time"] == NULL)? NULL: date_format(date_create($row["created_time"]),"Y/m/d H:i:s");
$row['last_use'] = ($row["last_use"] == NULL)? NULL: date_format(date_create($row["last_use"]),"Y/m/d H:i:s");
$row['updated_at'] = ($row["updated_at"] == NULL)? NULL: date_format(date_create($row["updated_at"]),"Y/m/d H:i:s");

$response = array("result"=>1,"detail"=>$row);
echo json_encode($response);
