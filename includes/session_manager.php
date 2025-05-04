<?php
/**
 * Session Management Functions
 * 
 * This file contains functions for session management and security.
 */

// Start session with secure settings
function secureSessionStart() {
    $session_name = 'DORMCLEARSESSION';
    
    // Set secure cookie parameters
    $secure = false; // Set to true if using HTTPS
    $httponly = true; // Prevent JavaScript access to session cookie
    
    // PHP 7.3.0 and newer configuration
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => 'Lax'
        ]);
    } else {
        session_set_cookie_params(0, '/', '', $secure, $httponly);
    }
    
    session_name($session_name);
    session_start();
    
    // Regenerate session ID every 30 minutes to prevent session fixation
    if (!isset($_SESSION['last_regeneration']) ||
        $_SESSION['last_regeneration'] < time() - 1800) {
        
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

/**
 * Check if session has expired due to inactivity
 * 
 * @param int $maxLifetime Maximum session lifetime in seconds (default 1 hour)
 * @return bool True if session has expired, false otherwise
 */
function hasSessionExpired($maxLifetime = 3600) {
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity'] > $maxLifetime)) {
        return true;
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
    return false;
}

/**
 * End user session and perform cleanup
 */
function endUserSession() {
    // Clear all session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    // Remove remember me cookies
    setcookie('dormclear_email', '', time() - 3600, '/');
    setcookie('dormclear_remember', '', time() - 3600, '/');
}

/**
 * Check for and process "remember me" functionality
 */
function processRememberMe() {
    if (!isLoggedIn() && 
        isset($_COOKIE['dormclear_email']) && 
        isset($_COOKIE['dormclear_remember']) && 
        $_COOKIE['dormclear_remember'] === 'true') {
        
        // Auto-populate login form with saved email
        $_SESSION['login_email'] = $_COOKIE['dormclear_email'];
        $_SESSION['login_remember'] = true;
    }
}

// Enhanced security functions

/**
 * Generate CSRF token for forms
 * 
 * @return string CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token from form submission
 * 
 * @param string $token Token from form submission
 * @return bool True if token is valid, false otherwise
 */
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Log failed login attempt and check for brute force attacks
 * 
 * @param string $email Email used in login attempt
 * @return bool True if account should be locked, false otherwise
 */
function logFailedLogin($email) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_attempt_email'] = $email;
        $_SESSION['login_attempt_time'] = time();
    } elseif ($_SESSION['login_attempt_email'] !== $email) {
        // Reset counter for new email
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_attempt_email'] = $email;
        $_SESSION['login_attempt_time'] = time();
    }
    
    $_SESSION['login_attempts']++;
    
    // Lock account after 5 failed attempts for 30 minutes
    if ($_SESSION['login_attempts'] >= 5) {
        if (time() - $_SESSION['login_attempt_time'] < 1800) {
            return true; // Account should be locked
        } else {
            // Reset after 30 minutes
            $_SESSION['login_attempts'] = 1;
            $_SESSION['login_attempt_time'] = time();
        }
    }
    
    return false;
}

/**
 * Check if an account is currently locked due to too many failed login attempts
 * 
 * @param string $email