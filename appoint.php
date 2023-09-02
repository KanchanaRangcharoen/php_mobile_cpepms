<?php
// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง
session_start();

if (!isset($_SESSION['student_id'])) {
    // ถ้ายังไม่ได้ล็อกอิน ให้เปลี่ยนเส้นทางการเข้าถึงหน้านี้ เช่น ไปหน้า login
    header("Location: login.php");
    exit();
}

// ต่อไปให้ดำเนินการดึงข้อมูลและประมวลผลต่อไป
require "connect.php"; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการเชื่อมต่อ
if (!$con) {
    echo "connection error";
} else {
    // ตั้งค่าการเข้ารหัส UTF-8
    mysqli_set_charset($con, "utf8");

    // คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง 'appoint'
    $sql = "SELECT * FROM appoint WHERE (DATE_FORMAT(appoint_date, '%Y%m%d') >= CONCAT(YEAR(CURDATE()) + 543, LPAD(MONTH(CURDATE()), 2, '0'), LPAD(DAY(CURDATE()), 2, '0'))) and ((group_id = (SELECT group_id FROM `student` WHERE student_id = ?)) or (group_id is null)) ORDER BY appoint_date ASC";

    // ตรวจสอบว่ามี 'student_id' ในเซสชันหรือไม่
    if (isset($_SESSION['student_id'])) {
        $studentId = $_SESSION['student_id'];
    } else {
        echo "Undefined 'student_id' in session";
        exit();
    }

    // เตรียมและผูกพารามิเตอร์
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $studentId);

    // ประมวลผลคำสั่ง
    $stmt->execute();

    // รับผลลัพธ์
    $result = $stmt->get_result();

    // ดึงข้อมูลเป็นอาร์เรย์แบบ associative
    $appoint = array();
    while ($row = $result->fetch_assoc()) {
        $appoint[] = $row;
    }
    // ตรวจสอบว่ามีข้อมูลใน $appoint หรือไม่
if (empty($appoint)) {
    echo json_encode(["error" => "ไม่พบข้อมูล"]);
} else {
    // ปิดการเชื่อมต่อ
    $con->close();

    // ตั้งค่า Header
    header('Content-Type: application/json; charset=utf-8');
    // ส่งข้อมูล JSON กลับไปยังแอปพลิเคชัน Flutter
    echo json_encode($appoint, JSON_UNESCAPED_UNICODE);
}}
?>
>>>>>>> 0017b53 (2/9/2566)
