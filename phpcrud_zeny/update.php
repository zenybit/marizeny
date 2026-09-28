<?php
include "auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: students.php");
    exit();
}

$id        = $_POST["id"] ?? "";
$firstname = trim($_POST["firstname"] ?? "");
$lastname  = trim($_POST["lastname"] ?? "");
$gender    = trim($_POST["gender"] ?? "");
$username  = trim($_POST["username"] ?? "");
$password  = $_POST["password"] ?? "";

if ($id === "" || $firstname === "" || $lastname === "" || $gender === "" || $username === "") {
    header("Location: edit.php?id=" . urlencode($id) . "&error=1");
    exit();
}

// Username must not belong to a different student
$check = $conn->prepare("SELECT Studentid FROM student WHERE username = ? AND Studentid <> ? LIMIT 1");
$check->bind_param("ss", $username, $id);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    header("Location: edit.php?id=" . urlencode($id) . "&error=taken");
    exit();
}
$check->close();

if ($password !== "") {
    $stmt = $conn->prepare("UPDATE student SET firstname=?, lastname=?, gender=?, username=?, PASSWORD=? WHERE Studentid=?");
    $stmt->bind_param("ssssss", $firstname, $lastname, $gender, $username, $password, $id);
} else {
    $stmt = $conn->prepare("UPDATE student SET firstname=?, lastname=?, gender=?, username=? WHERE Studentid=?");
    $stmt->bind_param("sssss", $firstname, $lastname, $gender, $username, $id);
}
$stmt->execute();

// Keep the welcome page in sync if you edited your own account
if ($id === $_SESSION["Studentid"]) {
    $_SESSION["firstname"] = $firstname;
    $_SESSION["lastname"]  = $lastname;
    $_SESSION["gender"]    = $gender;
    $_SESSION["username"]  = $username;
}

header("Location: students.php?success=1");
exit();