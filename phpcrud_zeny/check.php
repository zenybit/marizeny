<?php
session_start();
include "database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    header("Location: login.php?error=1");
    exit();
}

$stmt = $conn->prepare(
    "SELECT Studentid, firstname, lastname, gender, username, PASSWORD
     FROM student
     WHERE username = ?
     LIMIT 1"
);

if (!$stmt) {
    die("Database query failed: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Passwords in your table are plain text (1234); hashed ones also work
$ok = $student && (
    hash_equals((string)$student["PASSWORD"], $password) ||
    password_verify($password, $student["PASSWORD"])
);

if ($ok) {
    session_regenerate_id(true);
    $_SESSION["Studentid"] = $student["Studentid"];
    $_SESSION["firstname"] = $student["firstname"];
    $_SESSION["lastname"]  = $student["lastname"];
    $_SESSION["gender"]    = $student["gender"];
    $_SESSION["username"]  = $student["username"];
    header("Location: welcome.php");
} else {
    header("Location: login.php?error=1");
}
exit();