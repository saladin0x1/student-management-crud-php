<?php
// src/read.php

// Include the database connection file
$mysqli = require_once __DIR__ . '/database.php';

// Set a flag for debugging (set it to true to show debug messages)
$debug = true;

$students = [];
if ($mysqli) {
    $stmt = $mysqli->query("SELECT * FROM students");
    if (!$stmt) {
        // Log the error if debugging is enabled
        if ($debug) {
            error_log("[ERROR] Failed to fetch students: " . $mysqli->error);
        }
    } else {
        $students = $stmt->fetch_all(MYSQLI_ASSOC);
        
        // Log the fetched data if debugging is enabled
        if ($debug) {
            error_log("[DEBUG] Fetched Students: " . print_r($students, true));
        }
    }
}

// Return students data
return $students;
