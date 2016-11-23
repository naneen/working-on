<?php
session_start();

$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

$crossout_id = $_POST["crossout_id"];
$id = $_SESSION['ez_wko_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`, `status`, `done_date` FROM `to_do` WHERE to_do.owner_id=$id AND to_do.id=$crossout_id";
$result = $conn->query($sql);

$cmp = "";
if($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if(strcmp($row["status"], "in queue")==0) {
    $sql = "UPDATE `to_do` SET `status`='crossout' WHERE to_do.owner_id=$id AND to_do.id=$crossout_id";
    $conn->query($sql);
    $cmp = "statue = in queue";
  }
  elseif (strcmp($row["status"], "crossout")==0) {
    $sql = "UPDATE `to_do` SET `status`='in queue' WHERE to_do.owner_id=$id AND to_do.id=$crossout_id";
    $conn->query($sql);
    $cmp = "statue = crossout";
  }
}
// 	foreach ($result as $value) {
// 		$sql = "SELECT id FROM tag WHERE tag_name='" . $value . "'";
// 		$result = $conn->query($sql);
// 		if($result->num_rows > 0) {
// 			$row = $result->fetch_assoc();
// 			$t_id = $row['id'];
// 			$sql = "UPDATE tag SET last_use = CURRENT_TIMESTAMP WHERE id=" . $t_id;
// 			$conn->query($sql);
// 		}
// 		else {
// 			$sql = "INSERT INTO tag (id, tag_name, created_time, last_use, updated_at) VALUES (NULL, '" . $value . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";
// 			$result = $conn->query($sql);
// 			$sql = "SELECT id FROM tag WHERE tag_name='" . $value . "'";
// 			$result = $conn->query($sql);
// 			$row = $result->fetch_assoc();
// 			$t_id = $row['id'];
// 		}
//
// 		// $sql = "SELECT id FROM to_do WHERE added_date > CURRENT_DATE AND owner_id = " . $id . " ORDER BY start_time DESC LIMIT 1";
//     $sql = "SELECT id FROM to_do WHERE owner_id = " . $id . " ORDER BY added_date DESC LIMIT 1";
// 		$result = $conn->query($sql);
// 		$row = $result->fetch_assoc();
// 		$a_id = $row['id'];
//
// 		$sql = "INSERT INTO to_do_tag (to_do_id, tag_id, added_date) VALUES ('" . $a_id . "', '" . $t_id . "', CURRENT_TIMESTAMP)";
// 		$conn->query($sql);
// 	}
//
// 	$conn->close();
// 	$result = array('status' => 1);
// }
//  else {
// 	$result = array('status' => 0);


$todos = array();
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {

		$tmp_arr = array(
				'to_do_id' => $row["id"],
				'status' => $row["status"],
				'done_date' => $row["done_date"]);

		array_push($todos, $tmp_arr);
	}
}

$response = array("result"=>1,"todos"=>$todos);
// echo json_encode($response);
echo json_encode($cmp);
?>
