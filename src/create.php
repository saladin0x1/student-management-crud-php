<?php
// src/create.php

// Include the database connection
$mysqli = require_once __DIR__ . '/database.php';

// Check if the database connection is successful
if ($mysqli->connect_error) {
    error_log("[ERROR] Database connection failed in create.php: " . $mysqli->connect_error);
    die("Database connection failed. Please check the configuration.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Fetch data from the form
    $num = $_POST['num'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $filiere = $_POST['filiere'];

    // Prepare SQL query to insert the new student
    $stmt = $mysqli->prepare("INSERT INTO students (num, nom, prenom, email, filiere) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        error_log("[ERROR] SQL prepare failed: " . $mysqli->error);
        die("SQL preparation failed.");
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param('sssss', $num, $nom, $prenom, $email, $filiere);

    // Execute the query
//     if ($stmt->execute()) {
//         // Redirect to index.php after successful insertion to avoid resubmission on page refresh
//         header("Location: index.php");
//         exit();
//     } else {
//         error_log("[ERROR] SQL execute failed: " . $stmt->error);
//         die("Failed to insert the student. Please try again.");
//     }
// 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Student</h2>

        <!-- Form to Add New Student -->
        <form method="POST">
            <div class="mb-3">
                <label for="num" class="form-label">Student Number</label>
                <input type="text" class="form-control" id="num" name="num" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">First Name</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="filiere" class="form-label">Program</label>
                <input type="text" class="form-control" id="filiere" name="filiere" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Student</button>
        </form>

        <!-- Display Error Message if Database Connection Fails -->
        <?php if ($mysqli->connect_error): ?>
            <div class="alert alert-danger mt-4">
                Database connection failed. Some features may not work properly.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
