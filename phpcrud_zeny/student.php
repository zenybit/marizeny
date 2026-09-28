<?php include "auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page top">
    <section class="notebook full">
        <div class="cap"><i class="bi bi-people-fill"></i></div>
        <h1>Manage Students</h1>
        <p class="sub"><a href="welcome.php">Back to dashboard</a></p>

        <?php if (isset($_GET["success"])) { ?>
            <div class="alert alert-success py-2">Saved successfully.</div>
        <?php } ?>
        <?php if (isset($_GET["error"])) { ?>
            <div class="alert alert-danger py-2">
                <?php echo $_GET["error"] === "taken" ? "That username is already taken." : "Please fill in all required fields."; ?>
            </div>
        <?php } ?>

        <h2>Add student</h2>
        <form action="insert.php" method="POST" class="row g-3 mb-4">
            <input type="hidden" name="from" value="students">
            <div class="col-md-6"><label class="form-label">First name</label>
                <input type="text" name="firstname" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Last name</label>
                <input type="text" name="lastname" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select></div>
            <div class="col-md-4"><label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required></div>
            <div class="col-12"><button class="btn ink-btn"><i class="bi bi-plus-lg"></i> Add student</button></div>
        </form>

        <h2>Student list</h2>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead><tr><th>ID</th><th>First name</th><th>Last name</th><th>Gender</th><th>Username</th><th>Actions</th></tr></thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT Studentid, firstname, lastname, gender, username FROM student ORDER BY Studentid");
                if ($result && $result->num_rows > 0) {
                    while ($r = $result->fetch_assoc()) { $id = htmlspecialchars($r["Studentid"]); ?>
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo htmlspecialchars($r["firstname"]); ?></td>
                        <td><?php echo htmlspecialchars($r["lastname"]); ?></td>
                        <td><?php echo htmlspecialchars($r["gender"]); ?></td>
                        <td><?php echo htmlspecialchars($r["username"]); ?></td>
                        <td class="text-nowrap">
                            <a href="edit.php?id=<?php echo urlencode($r["Studentid"]); ?>" class="btn btn-sm pen-btn"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="delete.php" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this student?');">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } } else { ?>
                    <tr><td colspan="6" class="text-center">No students yet. Add one above.</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>