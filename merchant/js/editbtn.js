const editButton = document.getElementById('editButton');
const saveButton = document.getElementById('saveButton');
const cancelButton = document.getElementById('cancelButton');
const uploadButton = document.getElementById('uploadButton');
const resetButton = document.getElementById('resetImage');
const inputs = document.querySelectorAll('input[type="text"]');
const selects = document.querySelectorAll('select');  // Include dropdowns
const imageContainer = document.getElementById('profileImage');  // Image container

// Wait until the image is fully loaded before setting the originalImageSrc
let originalImageSrc;

imageContainer.onload = function() {
    originalImageSrc = imageContainer.src;
    console.log('Original Image Source:', originalImageSrc);  // Debugging output
    
    // If the image fails to load, use the default image
    if (!originalImageSrc || imageContainer.naturalWidth === 0) {
        originalImageSrc = 'images/user.png';
        imageContainer.src = originalImageSrc;
    }
};

editButton.addEventListener('click', () => {
    // Enable text inputs and dropdowns
    inputs.forEach(input => input.removeAttribute('readonly'));
    selects.forEach(select => select.removeAttribute('disabled'));  // Enable dropdowns
    
    // Show upload and reset buttons
    uploadButton.classList.remove('d-none');
    resetButton.classList.remove('d-none');
    
    // Toggle buttons visibility
    editButton.classList.add('d-none');
    saveButton.classList.remove('d-none');
    cancelButton.classList.remove('d-none');
});

cancelButton.addEventListener('click', () => {
    // Disable text inputs and dropdowns
    inputs.forEach(input => input.setAttribute('readonly', 'readonly'));
    selects.forEach(select => select.setAttribute('disabled', 'disabled'));  // Disable dropdowns
    
    // Hide upload and reset buttons
    uploadButton.classList.add('d-none');
    resetButton.classList.add('d-none');
    
    // Reset the image to the original source
    if (originalImageSrc) {
        imageContainer.src = originalImageSrc;
    }
    
    // Toggle buttons visibility
    editButton.classList.remove('d-none');
    saveButton.classList.add('d-none');
    cancelButton.classList.add('d-none');
});

saveButton.addEventListener('click', () => {
    // Submit the form (assuming the form ID is 'userProfileForm')
    document.getElementById('userProfileForm').submit();
});

resetButton.addEventListener('click', () => {
    // Reset the image to the original source
    if (originalImageSrc) {
        imageContainer.src = originalImageSrc;
    }
});
