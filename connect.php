<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$db_name = "cpepms";
$db_user = "root";
$db_pass = "";
$db_host = "localhost";

global $conn;
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
