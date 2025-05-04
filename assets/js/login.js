// Login page specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const loginForm = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset error styling
            emailInput.classList.remove('border-red-500');
            passwordInput.classList.remove('border-red-500');
            
            // Email validation
            if (!emailInput.value || !isValidEmail(emailInput.value)) {
                emailInput.classList.add('border-red-500');
                isValid = false;
                
                // Add error message if it doesn't exist
                if (!emailInput.nextElementSibling || !emailInput.nextElementSibling.classList.contains('error-message')) {
                    const errorMessage = document.createElement('p');
                    errorMessage.textContent = 'Please enter a valid email address';
                    errorMessage.classList.add('text-red-500', 'text-xs', 'mt-1', 'error-message');
                    emailInput.parentNode.insertBefore(errorMessage, emailInput.nextSibling);
                }
            } else {
                // Remove error message if it exists
                if (emailInput.nextElementSibling && emailInput.nextElementSibling.classList.contains('error-message')) {
                    emailInput.nextElementSibling.remove();
                }
            }
            
            // Password validation
            if (!passwordInput.value) {
                passwordInput.classList.add('border-red-500');
                isValid = false;
                
                // Add error message if it doesn't exist
                if (!passwordInput.nextElementSibling || !passwordInput.nextElementSibling.classList.contains('error-message')) {
                    const errorMessage = document.createElement('p');
                    errorMessage.textContent = 'Please enter your password';
                    errorMessage.classList.add('text-red-500', 'text-xs', 'mt-1', 'error-message');
                    passwordInput.parentNode.insertBefore(errorMessage, passwordInput.nextSibling);
                }
            } else {
                // Remove error message if it exists
                if (passwordInput.nextElementSibling && passwordInput.nextElementSibling.classList.contains('error-message')) {
                    passwordInput.nextElementSibling.remove();
                }
            }
            
            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Helper functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Remember me functionality
    const rememberCheckbox = document.querySelector('input[name="remember"]');
    
    if (rememberCheckbox) {
        // Check if there's a stored email in localStorage
        const storedEmail = localStorage.getItem('dormclear_email');
        const rememberedLogin = localStorage.getItem('dormclear_remember');
        
        if (storedEmail && rememberedLogin === 'true') {
            emailInput.value = storedEmail;
            rememberCheckbox.checked = true;
        }
        
        // Store email when "Remember me" is checked
        rememberCheckbox.addEventListener('change', function() {
            if (this.checked) {
                localStorage.setItem('dormclear_remember', 'true');
                if (emailInput.value) {
                    localStorage.setItem('dormclear_email', emailInput.value);
                }
            } else {
                localStorage.removeItem('dormclear_remember');
                localStorage.removeItem('dormclear_email');
            }
        });
    }
});