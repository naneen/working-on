<?php
session_start();
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "newDB";

$activity_id = $_POST["activity_id"];
$id = $_SESSION['ez_wko_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`, `status`, `done_date` FROM `to_do` WHERE to_do.owner_id=$id AND to_do.id=$activity_id";
$result = $conn->query($sql);

$cmp = "";

if($activity_id > 0){
  if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if(strcmp($row["status"], "in queue")==0) {
      $sql = "UPDATE `to_do` SET `status`='crossout', done_date=CURRENT_TIMESTAMP WHERE to_do.owner_id=$id AND to_do.id=$activity_id";
      $conn->query($sql);
      $cmp = "statue = crossout";
    }
    else {
      $sql = "UPDATE `to_do` SET `status`='in queue', done_date=NULL WHERE to_do.owner_id=$id AND to_do.id=$activity_id";
      $conn->query($sql);
      $cmp = "statue = in queue";
    }
  }
}
else {
  $sql = "UPDATE `to_do` SET `status`='removed', remove_date=CURRENT_TIMESTAMP WHERE date(CONVERT_TZ(to_do.done_date,'+00:00','+7:00')) < date(CONVERT_TZ(CURRENT_TIMESTAMP,'+00:00','+7:00'))";
  $conn->query($sql);
  $cmp = $activity_id;
}
// echo json_encode($response);
echo json_encode($cmp);
?>
