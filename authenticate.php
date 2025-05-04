<?php
// Start session
session_start();

// Include helper functions
require_once 'includes/functions.php';

// Check if already logged in
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $remember = isset($_POST['remember']) ? true : false;
    
    // Store email and remember preference in session for form repopulation if login fails
    $_SESSION['login_email'] = $email;
    $_SESSION['login_remember'] = $remember;
    
    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please enter both email and password.";
        header("Location: login.php");
        exit;
    }
    
    // Authenticate user
    $user = authenticateUser($email, $password);
    
    if ($user) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_logged_in'] = true;
        
        // Update last login time
        // updateLastLogin($user['user_id']);
        
        // Set remember me cookie if checked
        if ($remember) {
            setcookie('dormclear_email', $email, time() + (86400 * 30), "/"); // 30 days
            setcookie('dormclear_remember', 'true', time() + (86400 * 30), "/");
        } else {
            // Clear cookies if remember me is not checked
            if (isset($_COOKIE['dormclear_email'])) {
                setcookie('dormclear_email', '', time() - 3600, "/");
            }
            if (isset($_COOKIE['dormclear_remember'])) {
                setcookie('dormclear_remember', '', time() - 3600, "/");
            }
        }
        
        // Clear login form session variables
        unset($_SESSION['login_email']);
        unset($_SESSION['login_remember']);
        
        // Redirect to dashboard or requested page
        $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'index.php';
        unset($_SESSION['redirect_after_login']);
        
        header("Location: $redirect");
        exit;
    } else {
        // Authentication failed
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: login.php");
        exit;
    }
} else {
    // If not a POST request, redirect to login page
    header("Location: login.php");
    exit;
}
?>