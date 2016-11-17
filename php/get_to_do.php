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

$sql = "SELECT td.id as to_do_id, td.owner_id, td.task, t.tag_id, td.status
FROM to_do td INNER JOIN (
	SELECT to_do_id, tag_id
	FROM to_do_tag ) as t
	-- GROUP BY to_do_id) as t
WHERE td.id=t.to_do_id AND td.owner_id=$id
ORDER BY t.tag_id DESC, to_do_id ASC";

$conn->query('SET SQL_BIG_SELECTS=1');

$result = $conn->query($sql);

$todos = array();
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {

		$tmp_arr = array(
				'to_do_id' => $row["to_do_id"],
				'owner_id' => $row["owner_id"],
				'task' => $row["task"],
				'tag_id' => $row["tag_id"],
				'status' => $row["status"]);

		array_push($todos, $tmp_arr);
	}
}

//People who haven't yet gone online today
// $sql = "SELECT p.id owner_id, p.firstname, NULL status_text, p.last_login start_time, NULL end_time, p.last_login updated_at, CURRENT_TIMESTAMP AS 'time', 0 online FROM person p where p.status > 0 AND p.last_login < CURRENT_DATE";
//
// $result = $conn->query($sql);
//
// if ($result->num_rows > 0) {
// 	while($row = $result->fetch_assoc()) {
//
// 		$tmp_arr = array(
// 				'owner_id' => $row["owner_id"],
// 				'owner_name' => ($_SESSION['ez_wko_id'] == $row["owner_id"])?"You":$row["firstname"],
// 				'status_text' => $row["status_text"],
// 				'start_time' => ($row["start_time"] == NULL)? NULL: date_format(date_create($row["start_time"]),"Y/m/d H:i:s"),
// 				'end_time' => ($row["end_time"] == NULL)? NULL: date_format(date_create($row["end_time"]),"Y/m/d H:i:s"),
// 				'updated_at' => ($row["updated_at"] == NULL)? NULL: date_format(date_create($row["updated_at"]),"Y/m/d H:i:s"),
// 				'current_time' => ($row["time"] == NULL)? NULL: date_format(date_create($row["time"]),"Y/m/d H:i:s"),
// 				'online' => $row["online"],
// 			);
//
// 		array_push($todos, $tmp_arr);
// 	}
// }

$response = array("result"=>1,"todos"=>$todos);
echo json_encode($response);
?>
