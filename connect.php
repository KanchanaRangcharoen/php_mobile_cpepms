<?php
$db_name = "cpepms";
$db_user = "root";
$db_pass = "";
$db_host = "localhost";

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// ตรวจสอบการเชื่อมต่อ
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
