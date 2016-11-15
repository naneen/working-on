<?php
session_start();
$_SESSION['ez_wko_id'] = -1;
header("location:index.php");
?>