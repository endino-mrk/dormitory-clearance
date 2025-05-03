<?php
/**
 * Helper Functions for Dormitory Clearance System
 */

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