<?php
// update.php

// Include the database connection
$mysqli = require_once __DIR__ . '/database.php';

// Check if the student ID is passed via GET
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Fetch the student data based on the ID
    $stmt = $mysqli->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
}

// Handle the form submission for updating the student record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num = $_POST['num'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $filiere = $_POST['filiere'];

    // Update the student record
    $stmt = $mysqli->prepare("UPDATE students SET num = ?, nom = ?, prenom = ?, email = ?, filiere = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $num, $nom, $prenom, $email, $filiere, $studentId);

    if ($stmt->execute()) {
        // Redirect after successful update
        header("Location: ../index.php"); // Going up one directory level to the root
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Student</h2>

        <?php if (!$student): ?>
            <div class="alert alert-danger">
                Student not found!
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="num" class="form-label">Student Number</label>
                    <input type="text" class="form-control" id="num" name="num" value="<?php echo htmlspecialchars($student['num']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label">Name</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($student['nom']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Surname</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($student['prenom']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="filiere" class="form-label">Program</label>
                    <input type="text" class="form-control" id="filiere" name="filiere" value="<?php echo htmlspecialchars($student['filiere']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Student</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
