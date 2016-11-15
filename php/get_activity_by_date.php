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

$sql = "SELECT a.id activity_id, p.firstname, a.status_text, a.start_time, a.end_time, a.owner_id owner_id, CURRENT_TIMESTAMP time, IF( ISNULL(a.status_text), 0, IF( ISNULL(a.end_time), 1, 2 ) ) online FROM activity a, person p WHERE p.id = a.owner_id AND a.delete = 0 AND a.updated_at >= DATE('" . $_POST["start_time"] . "') AND a.updated_at < DATE('" . $_POST["end_time"] . "') ORDER BY a.start_time DESC";

$result = $conn->query($sql);

$activities = array();
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {

		$tmp_arr = array(
				'owner_id' => $row["owner_id"],
				'activity_id' => $row["activity_id"],
				'owner_name' => ($_SESSION['ez_wko_id'] == $row["owner_id"])?"You":$row["firstname"],
				'status_text' => $row["status_text"],
				'start_time' => ($row["start_time"] == NULL)? NULL: date_format(date_create($row["start_time"]),"Y/m/d H:i:s"),
				'end_time' => ($row["end_time"] == NULL)? NULL: date_format(date_create($row["end_time"]),"Y/m/d H:i:s"),
				'current_time' => ($row["time"] == NULL)? NULL: date_format(date_create($row["time"]),"Y/m/d H:i:s"),
				'online' => $row["online"],
				'editable' => ($row["end_time"] == NULL)? $_SESSION['ez_wko_id'] == $row["owner_id"] : false
			);

		array_push($activities, $tmp_arr);
	}
}


$response = array("result"=>1,"activities"=>$activities);
echo json_encode($response);
