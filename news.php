<?php
require "connect.php";
if (!$con) {
    echo "connection error";
}
// Set UTF-8 encoding
mysqli_set_charset($con, "utf8");
// Query to get data from the 'news' table
$sql = "SELECT * FROM news";
$result = $con->query($sql);

// Convert result to array
$newsList = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $newsList[] = $row;
    }
}

// Close connection
$con->close();

// Return JSON response with UTF-8 encoding
header('Content-Type: application/json; charset=utf-8');
echo json_encode($newsList, JSON_UNESCAPED_UNICODE);
?>
