<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Login';
$loginPage = true; // Flag to indicate this is the login page

// Include helper functions
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

// Include header with login modifications
include_once 'includes/login_header.php';
?>

<div class="h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-['Pacifico'] text-primary">DormClear</h1>
                    <h2 class="text-2xl font-bold text-gray-900 mt-4">Welcome back</h2>
                    <p class="mt-2 text-gray-500">Please enter your credentials to log in</p>
                </div>
                
                <?php
                // Display success message
                echo displayFlashMessage('success');
                
                // Display error message
                echo displayFlashMessage('error');
                ?>
                
                <form class="space-y-6" action="authenticate.php" method="post">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary" placeholder="Enter your email address" value="<?php echo isset($_SESSION['login_email']) ? $_SESSION['login_email'] : ''; ?>">
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <a href="forgot-password.php" class="text-sm text-primary hover:text-primary-dark">Forgot password?</a>
                        </div>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary" placeholder="Enter your password">
                    </div>
                    
                    <div class="flex items-center">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember" <?php echo isset($_SESSION['login_remember']) && $_SESSION['login_remember'] ? 'checked' : ''; ?>>
                            <span class="checkbox-mark"></span>
                        </label>
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors transform hover:scale-105 duration-200">
                        Log in
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-primary hover:underline">Register here</a></p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center text-gray-500 text-sm">
            <p>&copy; 2025 DormClear. All rights reserved.</p>
        </div>
    </div>
</div>

<?php
// Clear session variables
unset($_SESSION['login_email']);
unset($_SESSION['login_remember']);

// Include custom login footer
include_once 'includes/login_footer.php';
?>