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

$sql = "SELECT p.id owner_id, a.id activity_id, p.firstname, a.status_text status_text, a.start_time, a.end_time, a.updated_at, CURRENT_TIMESTAMP AS 'time', IF( ISNULL(a.status_text), 0, IF(ISNULL(a.end_time), 1, 2) ) online FROM person p LEFT JOIN ( SELECT a1.* FROM ( SELECT * FROM activity WHERE activity.delete = 0 ) a1 LEFT JOIN ( SELECT * FROM activity WHERE activity.delete = 0 ) a2 ON( a1.owner_id = a2.owner_id AND a1.id < a2.id ) WHERE a2.id IS NULL ) a ON p.id = a.owner_id WHERE p.status = 1 AND a.updated_at >= CURRENT_DATE ORDER BY a.updated_at DESC";
$conn->query('SET SQL_BIG_SELECTS=1');

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
				'updated_at' => ($row["updated_at"] == NULL)? NULL: date_format(date_create($row["updated_at"]),"Y/m/d H:i:s"),
				'current_time' => ($row["time"] == NULL)? NULL: date_format(date_create($row["time"]),"Y/m/d H:i:s"),
				'online' => $row["online"],
				'editable' => ($row["end_time"] == NULL)? ($_SESSION['ez_wko_id'] == $row["owner_id"]) || ($_SESSION['ez_wko_id'] == 12) : false
				//ID = 12 = Nenin = Admin
			);

		array_push($activities, $tmp_arr);
	}
}

//People who haven't yet gone online today
$sql = "SELECT p.id owner_id, p.firstname, NULL status_text, p.last_login start_time, NULL end_time, NULL updated_at, CURRENT_TIMESTAMP AS 'time', 0 online
FROM person p
WHERE id NOT IN (
select a.owner_id
from activity a
where a.start_time >= CURDATE() AND a.delete=0
GROUP by a.owner_id)";

// $sql = "SELECT p.id owner_id, p.firstname, NULL status_text, p.last_login start_time, NULL end_time, p.last_login updated_at, CURRENT_TIMESTAMP AS 'time', 0 online FROM person p where p.status > 0  AND p.last_login < CURRENT_DATE";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {

		$tmp_arr = array(
				'owner_id' => $row["owner_id"],
				'owner_name' => ($_SESSION['ez_wko_id'] == $row["owner_id"])?"You":$row["firstname"],
				'status_text' => $row["status_text"],
				'start_time' => ($row["start_time"] == NULL)? NULL: date_format(date_create($row["start_time"]),"Y/m/d H:i:s"),
				'end_time' => ($row["end_time"] == NULL)? NULL: date_format(date_create($row["end_time"]),"Y/m/d H:i:s"),
				'updated_at' => ($row["updated_at"] == NULL)? NULL: date_format(date_create($row["updated_at"]),"Y/m/d H:i:s"),
				'current_time' => ($row["time"] == NULL)? NULL: date_format(date_create($row["time"]),"Y/m/d H:i:s"),
				'online' => $row["online"],
			);

		array_push($activities, $tmp_arr);
	}
}


$response = array("result"=>1,"activities"=>$activities);
echo json_encode($response);
?>
