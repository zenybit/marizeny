<?php
// Connects to HeidiSQL/MySQL database shown in your screenshot
$conn = new mysqli("127.0.0.1", "root", "", "awa_bsis3c");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");