<?php
include "auth.php";

$id = $_POST["id"] ?? "";

// Don't let a student delete the account they are logged in with
if ($id !== "" && $id !== $_SESSION["Studentid"]) {
    $stmt = $conn->prepare("DELETE FROM student WHERE Studentid = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
}

header("Location: students.php");
exit();