<?php
/**
 * Helper Functions for Dormitory Clearance System
 */

// Include database functions
require_once 'db_functions.php';

// Function to get initials from name
function getInitials($name) {
    $nameParts = explode(' ', $name);
    $initials = '';
    
    if (count($nameParts) >= 2) {
        $initials = mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[1], 0, 1);
    } else {
        $initials = mb_substr($name, 0, 2);
    }
    
    return strtoupper($initials);
}

// Function to format date
function formatDate($date) {
    if (empty($date)) return '-';
    return date('M d, Y', strtotime($date));
}

// Function to format currency
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

// Function to get status class for residents
function getResidentStatusClass($status) {
    switch ($status) {
        case 'Active':
            return ['text-green-800', 'bg-green-100'];
        case 'Inactive':
            return ['text-red-800', 'bg-red-100'];
        case 'Moving Out':
            return ['text-yellow-800', 'bg-yellow-100'];
        default:
            return ['text-gray-800', 'bg-gray-100'];
    }
}

// Function to get status class for clearances
function getClearanceStatusClass($status) {
    switch ($status) {
        case 'Approved':
            return ['text-green-800', 'bg-green-100'];
        case 'Rejected':
            return ['text-red-800', 'bg-red-100'];
        case 'Pending':
            return ['text-yellow-800', 'bg-yellow-100'];
        default:
            return ['text-gray-800', 'bg-gray-100'];
    }
}

// Function to get status class for payments
function getPaymentStatusClass($status) {
    switch ($status) {
        case 'Paid':
            return ['text-green-800', 'bg-green-100'];
        case 'Partially Paid':
            return ['text-blue-800', 'bg-blue-100'];
        case 'Unpaid':
            return ['text-yellow-800', 'bg-yellow-100'];
        case 'Overdue':
            return ['text-red-800', 'bg-red-100'];
        default:
            return ['text-gray-800', 'bg-gray-100'];
    }
}

// Function to get completion status class
function getCompletionClass($status) {
    switch ($status) {
        case 'Complete':
            return ['text-green-800', 'bg-green-100'];
        case 'Incomplete':
            return ['text-red-800', 'bg-red-100'];
        case 'Pending':
            return ['text-yellow-800', 'bg-yellow-100'];
        case 'Approved':
            return ['text-green-800', 'bg-green-100'];
        default:
            return ['text-gray-800', 'bg-gray-100'];
    }
}

// Function to check if a page is active
function isPageActive($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page;
}

// Authentication related functions

/**
 * Check if user is logged in
 *
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
}

/**
 * Redirect if user is not logged in
 *
 * @param string $redirectTo Page to redirect to if not logged in
 * @return void
 */
function requireLogin($redirectTo = 'login.php') {
    if (!isLoggedIn()) {
        header("Location: $redirectTo");
        exit;
    }
}

/**
 * Check if user has a specific role
 *
 * @param string|array $roles Role or array of roles to check
 * @return bool True if user has any of the specified roles, false otherwise
 */
function hasRole($roles) {
    if (!isLoggedIn() || !isset($_SESSION['user_role'])) {
        return false;
    }
    
    if (is_array($roles)) {
        return in_array($_SESSION['user_role'], $roles);
    } else {
        return $_SESSION['user_role'] === $roles;
    }
}

/**
 * Redirect if user doesn't have required role
 *
 * @param string|array $roles Role or array of roles required
 * @param string $redirectTo Page to redirect to if user doesn't have required role
 * @return void
 */
function requireRole($roles, $redirectTo = 'index.php') {
    if (!hasRole($roles)) {
        $_SESSION['error'] = "You don't have permission to access that page.";
        header("Location: $redirectTo");
        exit;
    }
}

/**
 * Get current user ID
 *
 * @return int|null User ID if logged in, null otherwise
 */
function getCurrentUserId() {
    return isLoggedIn() ? $_SESSION['user_id'] : null;
}

/**
 * Get current username
 *
 * @return string|null Username if logged in, null otherwise
 */
function getCurrentUsername() {
    return isLoggedIn() ? $_SESSION['user_name'] : null;
}

/**
 * Display flash message and clear it from session
 *
 * @param string $type Message type (success, error, warning, info)
 * @return string HTML for flash message or empty string if no message
 */
function displayFlashMessage($type) {
    $output = '';
    
    if (isset($_SESSION[$type])) {
        $message = $_SESSION[$type];
        unset($_SESSION[$type]);
        
        $classes = '';
        switch ($type) {
            case 'success':
                $classes = 'bg-green-100 border-green-400 text-green-700';
                break;
            case 'error':
                $classes = 'bg-red-100 border-red-400 text-red-700';
                break;
            case 'warning':
                $classes = 'bg-yellow-100 border-yellow-400 text-yellow-700';
                break;
            case 'info':
                $classes = 'bg-blue-100 border-blue-400 text-blue-700';
                break;
        }
        
        $output = '<div class="' . $classes . ' px-4 py-3 rounded mb-4 border" role="alert">';
        $output .= '<span class="block sm:inline">' . $message . '</span>';
        $output .= '</div>';
    }
    
    return $output;
}