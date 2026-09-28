<?php
session_start();
include "database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

// Logged-in students adding from the manage page go back there
$fromManage = ($_POST["from"] ?? "") === "students" && isset($_SESSION["Studentid"]);
$back = $fromManage ? "students.php" : "index.php";

$firstname = trim($_POST["firstname"] ?? "");
$lastname  = trim($_POST["lastname"] ?? "");
$gender    = trim($_POST["gender"] ?? "");
$username  = trim($_POST["username"] ?? "");
$password  = $_POST["password"] ?? "";

if ($firstname === "" || $lastname === "" || $gender === "" || $username === "" || $password === "") {
    header("Location: $back?error=1");
    exit();
}

$check = $conn->prepare("SELECT Studentid FROM student WHERE username = ? LIMIT 1");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    header("Location: $back?error=taken");
    exit();
}
$check->close();

// Next ID: S001, S002, S003 -> S004
$row   = $conn->query("SELECT MAX(CAST(SUBSTRING(Studentid, 2) AS UNSIGNED)) AS n FROM student")->fetch_assoc();
$newId = "S" . str_pad(((int)$row["n"]) + 1, 3, "0", STR_PAD_LEFT);

$stmt = $conn->prepare(
    "INSERT INTO student (Studentid, firstname, lastname, gender, username, PASSWORD)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssssss", $newId, $firstname, $lastname, $gender, $username, $password);

if (!$stmt->execute()) {
    die("Insert failed: " . $stmt->error);
}

header("Location: " . ($fromManage ? "students.php?success=1" : "login.php?registered=1"));
exit();