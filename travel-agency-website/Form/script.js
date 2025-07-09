document.addEventListener('DOMContentLoaded', function() {
    const travelForm = document.getElementById('travelForm');
    const thankYouMessage = document.getElementById('thankYouMessage');
    const newBookingBtn = document.getElementById('newBookingBtn');
    const today = new Date().toISOString().split('T')[0];
    
    // Set min date for departure date to today
    document.getElementById('departureDate').min = today;
    
    // Validate return date is after departure date
    document.getElementById('departureDate').addEventListener('change', function() {
        const departureDate = this.value;
        document.getElementById('returnDate').min = departureDate;
        
        // If return date is before new departure date, clear it
        if (document.getElementById('returnDate').value < departureDate) {
            document.getElementById('returnDate').value = '';
        }
    });
    
    // Form validation
    travelForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset all error states
        clearErrors();
        
        // Validate each required field
        let isValid = true;
        
        // Personal Information
        if (!validateField('fullName', 'Please enter your full name')) isValid = false;
        if (!validateEmail('email', 'Please enter a valid email')) isValid = false;
        if (!validateField('phone', 'Please enter your phone number')) isValid = false;
        if (!validateField('dob', 'Please enter your date of birth')) isValid = false;
        
        // Trip Details
        if (!validateField('destination', 'Please select a destination')) isValid = false;
        if (!validateField('tripType', 'Please select a trip type')) isValid = false;
        if (!validateField('departureDate', 'Please select departure date')) isValid = false;
        if (!validateField('returnDate', 'Please select return date')) isValid = false;
        if (!validateField('travelers', 'Please enter number of travelers')) isValid = false;
        if (!validateField('budget', 'Please select a budget range')) isValid = false;
        
        // Accommodation Preferences
        if (!validateField('accommodation', 'Please select accommodation type')) isValid = false;
        if (!validateField('roomType', 'Please select room type')) isValid = false;
        
        if (isValid) {
            // In a real app, you would send the form data to the server here
            // For demo, we'll just show the thank you message
            showThankYouMessage();
        }
    });
    
    // Reset form
    travelForm.addEventListener('reset', function() {
        clearErrors();
    });
    
    // New booking button
    newBookingBtn.addEventListener('click', function() {
        hideThankYouMessage();
        travelForm.reset();
    });
    
    // Field validation functions
    function validateField(fieldId, errorMessage) {
        const field = document.getElementById(fieldId);
        const value = field.value.trim();
        
        if (value === '') {
            showError(field, errorMessage);
            return false;
        }
        
        return true;
    }
    
    function validateEmail(fieldId, errorMessage) {
        const field = document.getElementById(fieldId);
        const email = field.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === '' || !emailRegex.test(email)) {
            showError(field, errorMessage);
            return false;
        }
        
        return true;
    }
    
    function showError(field, message) {
        const inputGroup = field.closest('.input-group');
        inputGroup.classList.add('error');
        
        let errorElement = inputGroup.querySelector('.error-message');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            inputGroup.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
    }
    
    function clearErrors() {
        const errorGroups = document.querySelectorAll('.input-group.error');
        errorGroups.forEach(group => {
            group.classList.remove('error');
            const errorMessage = group.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.textContent = '';
            }
        });
    }
    
    function showThankYouMessage() {
        thankYouMessage.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function hideThankYouMessage() {
        thankYouMessage.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    // Add animation to form elements on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.input-group, fieldset');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.1;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Set initial state for animation
    const formElements = document.querySelectorAll('.input-group, fieldset');
    formElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
    });
    
    // Run animation on load and scroll
    window.addEventListener('load', animateOnScroll);
    window.addEventListener('scroll', animateOnScroll);
});

document.getElementById('travelForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Collect all form data
    const formData = new FormData(this);
    const interests = [];
    document.querySelectorAll('input[name="interests"]:checked').forEach(checkbox => {
        interests.push(checkbox.value);
    });
    
    // Add interests to form data
    formData.append('interests', JSON.stringify(interests));
    
    // Submit via AJAX
    fetch('process_booking.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show thank you message
            document.getElementById('thankYouMessage').style.cssText = `
                opacity : 1;
                visibility : visible;
            `
            document.getElementById('thankYouMessage').classList.add('active')
            document.getElementById('travelForm').style.display = 'none';
        } else {
            alert('Error submitting booking: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
    });
});

// Handle new booking button
document.getElementById('newBookingBtn').addEventListener('click', function() {
    document.getElementById('thankYouMessage').style.display = 'none';
    document.getElementById('travelForm').style.display = 'block';
    document.getElementById('travelForm').reset();
    location.reload()
});

document.querySelector('.fa-xmark').addEventListener('click', ()=>{
    document.getElementById('thankYouMessage').style.display = 'none';
    document.getElementById('travelForm').style.display = 'block';
    document.getElementById('travelForm').reset();
    location.reload()
})