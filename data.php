<?php
include 'conn.php';

$studentTotal = $conn->query("SELECT COUNT (*) AS total FROM students")->fetch_assoc()['total'];
$facultyTotal = $conn->query("SELECT COUNT (*) AS total FROM faculty")->fetch_assoc()['total'];
$administratorTotal = $conn->query("SELECT COUNT (*) AS total FROM administrators")->fetch_assoc()['total'];
$registrarTotal = $conn->query("SELECT COUNT (*) AS total FROM registrar")->fetch_assoc()['total'];
$securityTotal = $conn->query("SELECT COUNT (*) AS total FROM security")->fetch_assoc()['total'];

$data = ["students" => $studentTotal, "faculty" => $facultyTotal, "administrators" => $administratorTotal, "registrar" => $registrarTotal, "security" => $securityTotal];

?>