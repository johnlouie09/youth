<?php
// Database configuration
$host = "localhost";  // Change if hosted elsewhere
$dbname = "youth";  // Database name
$username = "root";  // Change based on your database username
$password = "";  // Change based on your database password

// Create a connection using MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Uncomment for debugging
// echo "Database connected successfully!";
?>