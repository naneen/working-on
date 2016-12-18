<?php
session_start();
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

$id = $_SESSION['ez_wko_id'];
$owner = $_POST["owner"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$wantedID = $id;
if (strcmp($owner, "own")!=0) {
	$wantedID = $owner;
}

$sql = "SELECT td.id as to_do_id, td.owner_id, td.task, t.tag_id, td.status, t.tag_name
FROM to_do td INNER JOIN (
	SELECT d.to_do_id, d.tag_id, g.tag_name
	FROM to_do_tag d, tag g
	WHERE g.id=d.tag_id) as t
WHERE td.id=t.to_do_id AND td.owner_id=$wantedID AND td.status not like '%removed%'
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
				'status' => $row["status"],
				'tag_name' => $row["tag_name"]);

		array_push($todos, $tmp_arr);
	}
}

$response = array("result"=>1,"todos"=>$todos);
echo json_encode($response);
?>
