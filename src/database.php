<?php
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php'; // Make sure Composer autoloader is included

// Initialize Dotenv and load the .env file from the root directory
$dotenv = new Dotenv();

// Set the correct path to the .env file located in the root directory
$envFilePath = __DIR__ . '/../.env';  // Correct path to the .env file in the root directory

// Load the .env file
try {
    $dotenv->load($envFilePath);
} catch (Exception $e) {
    error_log('Failed to load .env file. Error: ' . $e->getMessage());
    die('Failed to load .env file. Please check your configuration.');
}

// Define whether to use fallback values when the environment variables are missing
$useFallback = false;

// Fetch the database connection parameters from the environment variables
$dbHost = $_ENV['DB_HOST'] ?? null;
$dbPort = $_ENV['DB_PORT'] ?? null;
$dbName = $_ENV['DB_NAME'] ?? null;
$dbUsername = $_ENV['DB_USER'] ?? null;
$dbPassword = $_ENV['DB_PASSWORD'] ?? null;

// Apply fallback values if the flag is set to true and environment variables are missing
if ($useFallback) {
    $dbHost = $dbHost ?: '-'; // Default to '-' if DB_HOST is not set
    $dbPort = $dbPort ?: '3306'; // Default to '3306' if DB_PORT is not set
    $dbName = $dbName ?: '-'; // Default to '-' if DB_NAME is not set
    $dbUsername = $dbUsername ?: '-'; // Default to '-' if DB_USER is not set
    $dbPassword = $dbPassword ?: '-'; // Default to '-' if DB_PASSWORD is not set
}

// Create the MySQL connection using mysqli
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

// Check for connection errors
if ($mysqli->connect_error) {
    error_log("Database connection failed: " . $mysqli->connect_error);
    die("Database connection failed. Please try again later.");
}

// SQL query to create the students table if it does not exist
$tableCreationQuery = "
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    num VARCHAR(20) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    filiere VARCHAR(100) NOT NULL
);";

// Execute the query to create the table
if ($mysqli->query($tableCreationQuery) === TRUE) {
    error_log("Table 'students' is ready or already exists.");
} else {
    error_log("Error creating table: " . $mysqli->error);
    die("Error creating table: " . $mysqli->error);
}

// Return the mysqli instance for reuse
return $mysqli;
?>
