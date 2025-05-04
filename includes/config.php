<?php
/**
 * Database Configuration File
 * 
 * This file contains database connection settings for the DormClear application.
 */

// Define database constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // Change to your database username
define('DB_PASS', '');         // Change to your database password
define('DB_NAME', 'dormitory_clearance');

// Create database connection
function connectDB() {
    $conn = null;
    
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }
        
        // Set charset
        $conn->set_charset('utf8mb4');
        
    } catch (Exception $e) {
        // Log error and show user-friendly message
        error_log('Connection error: ' . $e->getMessage());
        die('We are experiencing technical difficulties. Please try again later.');
    }
    
    return $conn;
}

// Get database connection
$conn = connectDB();
?>