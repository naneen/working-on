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

if($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if(strcmp($row["status"], "in queue")==0) {
    $sql = "UPDATE `to_do` SET `status`='crossout', done_date = CURRENT_TIMESTAMP WHERE to_do.owner_id=$id AND to_do.id=$crossout_id";
    $conn->query($sql);
  }
  elseif (strcmp($row["status"], "crossout")==0) {
    $sql = "UPDATE `to_do` SET `status`='in queue', done_date = NULL WHERE to_do.owner_id=$id AND to_do.id=$crossout_id";
    $conn->query($sql);
  }
}
?>
