<?php
require "connect.php";
if (!$con) {
    echo "connection error";
}

$email = $_POST['email'];
$password = $_POST['password'];

// Prepare the SQL statement with placeholders to prevent SQL injection
$sql = "SELECT * FROM student WHERE student_id = ?;";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count = mysqli_num_rows($result);

if ($count == 1) {
    // You should fetch the row and verify the password using password_verify
    $row = mysqli_fetch_array($result);
    $hashedPassword = $row['student_password'];

    if (password_verify($password, $hashedPassword)) {
        echo json_encode("Student Success");
    } else {
        echo json_encode("Error");
    }
} else {
    $sql2 = "SELECT * FROM teacher WHERE teacher_id = ?;";
    $stmt2 = mysqli_prepare($con, $sql2);
    mysqli_stmt_bind_param($stmt2, "s", $email);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    if (mysqli_num_rows($result2) == 1) {
        $row = mysqli_fetch_array($result2);
        $hashedPassword = $row['teacher_password'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['teacher_id'] = $row['teacher_id'];
            $_SESSION['teacher_password'] = $row['teacher_password'];
            $_SESSION['level_id'] = $row['level_id'];

            if ($_SESSION['level_id'] == 1) {
                echo json_encode("Teacher Success");
            }
        } else {
            echo json_encode("Error");
        }
    } else {
        echo json_encode("Error");
    }
}
