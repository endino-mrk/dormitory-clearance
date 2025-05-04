<?php
/**
 * Database Helper Functions
 * 
 * This file contains functions for interacting with the database.
 */

// Include database configuration
require_once 'config.php';

/**
 * Sanitize user input to prevent SQL injection
 *
 * @param string $data User input to sanitize
 * @return string Sanitized input
 */
function sanitizeInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

/**
 * Check if a user exists by email
 *
 * @param string $email User email
 * @return bool True if user exists, false otherwise
 */
function userExistsByEmail($email) {
    global $conn;
    $email = sanitizeInput($email);
    
    $sql = "SELECT user_id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    return ($result && $result->num_rows > 0);
}

/**
 * Check if a user exists by username
 *
 * @param string $username Username
 * @return bool True if user exists, false otherwise
 */
function userExistsByUsername($username) {
    global $conn;
    $username = sanitizeInput($username);
    
    $sql = "SELECT user_id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    return ($result && $result->num_rows > 0);
}

/**
 * Authenticate user and return user data if successful
 *
 * @param string $email User email
 * @param string $password User password (plaintext)
 * @return array|bool User data array if authentication successful, false otherwise
 */
function authenticateUser($email, $password) {
    global $conn;
    $email = sanitizeInput($email);
    
    // Get user from database - fix the ambiguous user_id column by using table aliases
    $sql = "SELECT u.user_id, u.first_name, u.last_name, u.middle_name, u.email, u.password, 
                   u.active, u.created_at, r.name as role_name 
            FROM users u
            LEFT JOIN user_roles ur ON u.user_id = ur.user_id
            LEFT JOIN roles r ON ur.role_id = r.role_id
            WHERE u.email = '$email' AND u.active = 1";
    
    $result = $conn->query($sql);
    
    // Check if user exists and is active
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password (using PHP's password_verify function for hashed passwords)
        if (password_verify($password, $user['password'])) {
            // Remove password from user data before returning
            unset($user['password']);
            return $user;
        }
    }
    
    return false;
}

/**
 * Register a new user
 *
 * @param array $userData User data (first_name, last_name, middle_name, username, email, password)
 * @return int|bool New user ID if successful, false otherwise
 */
function registerUser($userData) {
    global $conn;
    
    // Sanitize input
    $firstName = sanitizeInput($userData['first_name']);
    $lastName = sanitizeInput($userData['last_name']);
    $middleName = sanitizeInput($userData['middle_name']);
    $username = sanitizeInput($userData['username']);
    $email = sanitizeInput($userData['email']);
    $password = password_hash($userData['password'], PASSWORD_DEFAULT); // Hash password
    
    // Get current timestamp
    $now = date('Y-m-d H:i:s');
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Insert into users table
        $sql = "INSERT INTO users (first_name, last_name, middle_name, username, email, password, active, created_at) 
                VALUES ('$firstName', '$lastName', '$middleName', '$username', '$email', '$password', 1, '$now')";
        
        if (!$conn->query($sql)) {
            throw new Exception("Error inserting user: " . $conn->error);
        }
        
        $userId = $conn->insert_id;
        
        // Assign default role (assuming 1 is Resident role)
        $defaultRoleId = 1; // Resident role ID
        
        $sql = "INSERT INTO user_roles (user_id, role_id) VALUES ($userId, $defaultRoleId)";
        
        if (!$conn->query($sql)) {
            throw new Exception("Error assigning role: " . $conn->error);
        }
        
        // If userData contains resident info, insert into residents table
        if (isset($userData['student_id'])) {
            $studentId = sanitizeInput($userData['student_id']);
            $college = isset($userData['college']) ? sanitizeInput($userData['college']) : '';
            $program = isset($userData['program']) ? sanitizeInput($userData['program']) : '';
            $yearLevel = isset($userData['year_level']) ? sanitizeInput($userData['year_level']) : null;
            
            $sql = "INSERT INTO residents (user_id, student_id, college, program, year_level, active) 
                    VALUES ($userId, '$studentId', '$college', '$program', " . 
                    ($yearLevel ? "'$yearLevel'" : "NULL") . ", 1)";
            
            if (!$conn->query($sql)) {
                throw new Exception("Error inserting resident info: " . $conn->error);
            }
        }
        
        // Commit transaction
        $conn->commit();
        
        return $userId;
    } catch (Exception $e) {
        // Roll back transaction on error
        $conn->rollback();
        error_log($e->getMessage());
        return false;
    }
}

/**
 * Get user data by ID
 *
 * @param int $userId User ID
 * @return array|bool User data if found, false otherwise
 */
function getUserById($userId) {
    global $conn;
    $userId = (int)$userId;
    
    $sql = "SELECT u.user_id, u.first_name, u.last_name, u.middle_name, u.username, u.email, 
                   u.active, u.created_at, r.name as role_name 
            FROM users u
            LEFT JOIN user_roles ur ON u.user_id = ur.user_id
            LEFT JOIN roles r ON ur.role_id = r.role_id
            WHERE u.user_id = $userId";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return false;
}

/**
 * Update user last login time
 *
 * @param int $userId User ID
 * @return bool True if successful, false otherwise
 */
function updateLastLogin($userId) {
    global $conn;
    $userId = (int)$userId;
    $now = date('Y-m-d H:i:s');
    
    $sql = "UPDATE users SET last_login = '$now' WHERE user_id = $userId";
    
    return $conn->query($sql);
}

/**
 * Generate password reset token and store in database
 *
 * @param string $email User email
 * @return string|bool Reset token if successful, false otherwise
 */
function generatePasswordResetToken($email) {
    global $conn;
    $email = sanitizeInput($email);
    
    // Check if user exists
    if (!userExistsByEmail($email)) {
        return false;
    }
    
    // Generate token
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Store token in database (you would need to create a password_reset_tokens table)
    $sql = "INSERT INTO password_reset_tokens (email, token, expires) 
            VALUES ('$email', '$token', '$expires')";
    
    if ($conn->query($sql)) {
        return $token;
    }
    
    return false;
}
?>