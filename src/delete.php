<?php
// delete.php

// Include the database connection
$mysqli = require_once __DIR__ . '/database.php';

// Check if the student ID is passed via GET
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Delete the student record from the database
    $stmt = $mysqli->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $studentId);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: ../index.php"); // Going up one level to the root directory
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
