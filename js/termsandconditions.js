$(document).ready(function() {
    // Function to show the Terms & Conditions modal
    function showTermsModal() {
        $('#iagreeModal').modal('show');
    }

    // Function to handle the checkbox in the container
    function handleCheckboxChange() {
        if ($('#register-check').is(':checked')) {
            showTermsModal(); // Show the modal if the checkbox is checked
        } else {
            $('#agreeCheckbox').prop('checked', false); // Uncheck the modal checkbox if the main checkbox is unchecked
        }
    }

    // Handle click on the main "Terms & Conditions" checkbox
    $('#register-check').change(function() {
        handleCheckboxChange();
    });

    // Handle change event for the "I Agree" checkbox inside the modal
    $('#agreeCheckbox').change(function() {
        if ($(this).is(':checked')) {
            $('#iagreeModal').modal('hide'); // Close the modal when "I Agree" checkbox is checked
            $('#register-check').prop('checked', true); // Ensure the main checkbox remains checked
        }
    });

    // Handle modal close event to ensure main checkbox reflects state
    $('#iagreeModal').on('hidden.bs.modal', function() {
        if (!$('#agreeCheckbox').is(':checked')) {
            $('#register-check').prop('checked', false); // Uncheck the main checkbox if "I Agree" is not checked
        }
    });
});
