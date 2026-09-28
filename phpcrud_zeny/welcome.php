<?php
session_start();
if (!isset($_SESSION["Studentid"])) {
    header("Location: login.php");
    exit();
}
$h = fn($v) => htmlspecialchars(ucwords((string)$v));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page">
    <section class="notebook wide">
        <div class="cap"><i class="bi bi-mortarboard-fill"></i></div>
        <h1>Welcome, <mark><?php echo $h($_SESSION["firstname"]); ?></mark>!</h1>
        <p class="sub">You are logged in as a student.</p>

        <div class="id-card">
            <div class="row"><span>Student ID</span><b><?php echo htmlspecialchars($_SESSION["Studentid"]); ?></b></div>
            <div class="row"><span>Full name</span><b><?php echo $h($_SESSION["firstname"] . " " . $_SESSION["lastname"]); ?></b></div>
            <div class="row"><span>Gender</span><b><?php echo $h($_SESSION["gender"]); ?></b></div>
            <div class="row"><span>Username</span><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></div>
        </div>

        <a href="students.php" class="btn pen-btn mt-4"><i class="bi bi-people"></i> Manage students</a>
        <a href="logout.php" class="btn ink-btn mt-4"
           onclick="return confirm('Log out now?');">
            <i class="bi bi-box-arrow-right"></i> Log out
        </a>
    </section>
</main>
</body>
</html>