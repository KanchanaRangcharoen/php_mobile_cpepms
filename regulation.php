<?php
require "connect.php";
if (!$con) {
    echo "connection error";
}
// Set UTF-8 encoding
mysqli_set_charset($con, "utf8");
// Query to get data from the 'rules' table
$sql = "SELECT * FROM regulation";
$result = $con->query($sql);

// Convert result to array
$rulesList = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rulesList[] = $row;
    }
}

// Close connection
$con->close();

// Return JSON response with UTF-8 encoding
header('Content-Type: application/json; charset=utf-8');
echo json_encode($rulesList, JSON_UNESCAPED_UNICODE);
?>
