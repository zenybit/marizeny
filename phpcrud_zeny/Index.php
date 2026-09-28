<?php
session_start();
if (isset($_SESSION["Studentid"])) {
    header("Location: welcome.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page">
    <section class="notebook">
        <div class="cap"><i class="bi bi-person-plus-fill"></i></div>
        <h1>Add Student</h1>
        <p class="sub">Create your student account first.</p>

        <?php if (isset($_GET["error"])) { ?>
            <div class="alert alert-danger py-2">
                <?php echo $_GET["error"] === "taken" ? "That username is already taken." : "Please fill in all fields."; ?>
            </div>
        <?php } ?>

        <form action="insert.php" method="POST">
            <label class="form-label">First name</label>
            <input type="text" name="firstname" class="form-control mb-2" required autofocus>

            <label class="form-label">Last name</label>
            <input type="text" name="lastname" class="form-control mb-2" required>

            <label class="form-label">Gender</label>
            <select name="gender" class="form-control mb-2" required>
                <option value="">Select</option>
                <option value="female">Female</option>
                <option value="male">Male</option>
            </select>

            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control mb-2" required>

            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control mb-4" required>

            <button type="submit" class="btn ink-btn w-100">Add student</button>
        </form>

        <p class="mt-3 mb-0">Already have an account? <a href="login.php">Log in</a></p>
    </section>
</main>
</body>
</html>