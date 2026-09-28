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
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page">
    <section class="notebook">
        <div class="cap"><i class="bi bi-mortarboard-fill"></i></div>
        <h1>Student Login</h1>
        <p class="sub">Sign in to see your student page.</p>

        <?php if (isset($_GET["registered"])) { ?>
            <div class="alert alert-success py-2">Account created! Log in below.</div>
        <?php } ?>

        <?php if (isset($_GET["error"])) { ?>
            <div class="alert alert-danger py-2">
                <i class="bi bi-exclamation-circle"></i> Wrong username or password. Try again.
            </div>
        <?php } ?>

        <form action="check.php" method="POST">
            <label class="form-label" for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control mb-3"
                   placeholder="e.g. zeny" required autofocus>

            <label class="form-label" for="password">Password</label>
            <div class="input-group mb-4">
                <input type="password" id="password" name="password" class="form-control" required>
                <button class="btn pen-btn" type="button" id="toggle" aria-label="Show password">
                    <i class="bi bi-eye" id="eye"></i>
                </button>
            </div>

            <button type="submit" class="btn ink-btn w-100">Log in</button>
        </form>
        <p class="mt-3 mb-0">New here? <a href="index.php">Add a student account</a></p>
    </section>
</main>

<script>
const pw = document.getElementById("password"), eye = document.getElementById("eye");
document.getElementById("toggle").addEventListener("click", () => {
    const show = pw.type === "password";
    pw.type = show ? "text" : "password";
    eye.className = show ? "bi bi-eye-slash" : "bi bi-eye";
});
</script>
</body>
</html>