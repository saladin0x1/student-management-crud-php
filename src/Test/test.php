<?php
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php'; // Load the Composer autoload

// Initialize Dotenv and load the .env file from the root directory
$dotenv = new Dotenv();

// Log the current directory and check the file path
echo 'Current Directory: ' . __DIR__ . PHP_EOL;

// Set the correct path to the .env file located in the root directory
$envFilePath = __DIR__ . '/../.env';  // Correct path to the .env file in the root directory
echo 'Attempting to load .env from: ' . $envFilePath . PHP_EOL;

// Load the .env file
try {
    $dotenv->load($envFilePath);
    echo '.env file loaded successfully!' . PHP_EOL;
} catch (Exception $e) {
    echo 'Failed to load .env file. Error: ' . $e->getMessage() . PHP_EOL;
}

// Output the environment variables using $_ENV
echo 'DB Host: ' . $_ENV['DB_HOST'] . PHP_EOL;
echo 'DB Port: ' . $_ENV['DB_PORT'] . PHP_EOL;
echo 'DB Name: ' . $_ENV['DB_NAME'] . PHP_EOL;
echo 'DB User: ' . $_ENV['DB_USER'] . PHP_EOL;
echo 'DB Password: ' . $_ENV['DB_PASSWORD'] . PHP_EOL;
?>
