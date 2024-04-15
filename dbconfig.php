<?php

$host = 'localhost';
$dbname = 'account';
$user = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;port=3307"; // Update port to match my.ini

// Set PDO to throw exceptions for errors
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode to associative array
];

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $password, $options);
    // testing:
    // echo "Connection Done!";
} catch(PDOException $e) {
    // If there is an error in database connection, this message will be printed and the application will continue loading
    // php.net- Link: https://www.php.net/manual/en/exception.getmessage.php
    echo "Database Connection failed: " . $e->getMessage();
    // Using the keyword "throw" to STOP the execution of our app and display the error message
    throw new PDOException($e->getMessage());
}
?>
