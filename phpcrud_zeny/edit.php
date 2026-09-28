<?php
include "auth.php";

$id = $_GET["id"] ?? "";
$stmt = $conn->prepare("SELECT Studentid, firstname, lastname, gender, username FROM student WHERE Studentid = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$s = $stmt->get_result()->fetch_assoc();

if (!$s) {
    header("Location: students.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page">
    <section class="notebook">
        <div class="cap"><i class="bi bi-pencil-fill"></i></div>
        <h1>Edit Student</h1>
        <p class="sub">ID: <?php echo htmlspecialchars($s["Studentid"]); ?></p>

        <?php if (isset($_GET["error"])) { ?>
            <div class="alert alert-danger py-2">
                <?php echo $_GET["error"] === "taken" ? "That username is already taken." : "Please fill in all required fields."; ?>
            </div>
        <?php } ?>

        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($s["Studentid"]); ?>">

            <label class="form-label">First name</label>
            <input type="text" name="firstname" class="form-control mb-2" value="<?php echo htmlspecialchars($s["firstname"]); ?>" required>

            <label class="form-label">Last name</label>
            <input type="text" name="lastname" class="form-control mb-2" value="<?php echo htmlspecialchars($s["lastname"]); ?>" required>

            <label class="form-label">Gender</label>
            <select name="gender" class="form-control mb-2" required>
                <option value="female" <?php echo strtolower($s["gender"]) === "female" ? "selected" : ""; ?>>Female</option>
                <option value="male" <?php echo strtolower($s["gender"]) === "male" ? "selected" : ""; ?>>Male</option>
            </select>

            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control mb-2" value="<?php echo htmlspecialchars($s["username"]); ?>" required>

            <label class="form-label">New password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control mb-4">

            <button type="submit" class="btn ink-btn">Save changes</button>
            <a href="students.php" class="btn pen-btn">Cancel</a>
        </form>
    </section>
</main>
</body>
</html>