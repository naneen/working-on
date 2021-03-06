<?php
session_start();
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

$text = $_POST["status_text"];
$id = $_SESSION['ez_wko_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function startsWith($haystack, $needle) {
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

$text_arr = explode( ' ', $text );
$tag_array = array();
foreach ($text_arr as $value) {
	if(startsWith($value, '#'))
		array_push($tag_array, strtolower(str_replace("#","",$value)));
}

$tag_array = array_unique($tag_array);

if(sizeof($tag_array) > 0) {
	$sql = "INSERT INTO activity (id, start_time, end_time, status_text, owner_id, updated_at) VALUES (NULL, CURRENT_TIMESTAMP, NULL, '". $text ."', '". $id ."', CURRENT_TIMESTAMP)";
	$result = $conn->query($sql);

	foreach ($tag_array as $value) {
		$sql = "SELECT id FROM tag WHERE tag_name='" . $value . "'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$t_id = $row['id'];
			$sql = "UPDATE tag SET last_use = CURRENT_TIMESTAMP WHERE id=" . $t_id;
			$conn->query($sql);
		}
		else {
			$sql = "INSERT INTO tag (id, tag_name, created_time, last_use, updated_at) VALUES (NULL, '" . $value . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
			$result = $conn->query($sql);
			$sql = "SELECT id FROM tag WHERE tag_name='" . $value . "'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$t_id = $row['id'];
		}

		$sql = "SELECT id FROM activity WHERE start_time > CURRENT_DATE AND owner_id = " . $id . " ORDER BY start_time DESC LIMIT 1";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$a_id = $row['id'];

		$sql = "INSERT INTO activity_tag (activity_id, tag_id, updated_at) VALUES ('" . $a_id . "', '" . $t_id . "', CURRENT_TIMESTAMP)";
		$conn->query($sql);
	}

	$conn->close();

	$result = array('status' => 1);

} else {
	$result = array('status' => 0);
}

echo json_encode($result);
?>
