<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'database';

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
S
?>