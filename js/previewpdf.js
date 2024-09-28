let uploadedFiles = {}; // Track uploaded files by their input ID

function previewPDF(input, inputId) {
    const file = input.files[0];

    // If there is already an uploaded file, show it in the modal
    if (uploadedFiles[inputId]) {
        const previewElement = document.getElementById('pdfPreviewFrame');
        previewElement.src = URL.createObjectURL(uploadedFiles[inputId]);
        previewElement.dataset.inputId = inputId; // Store the inputId for later use
        $('#pdfModal').modal('show');
        return;
    }

    // If no file is uploaded yet, preview the new file
    if (file && file.type === "application/pdf") {
        const previewElement = document.getElementById('pdfPreviewFrame');
        previewElement.src = URL.createObjectURL(file);
        uploadedFiles[inputId] = file; // Store the uploaded file
        previewElement.dataset.inputId = inputId; // Store the inputId for later use
        $('#pdfModal').modal('show');
        updateLabel(input, "File Uploaded");
    } else {
        alert("Please upload a valid PDF file.");
        input.value = ""; // Clear the file input if not a PDF
    }
}

function removePDF() {
    const previewElement = document.getElementById('pdfPreviewFrame');
    const inputId = previewElement.dataset.inputId; // Get the inputId from the preview element
    const inputElement = document.getElementById(inputId);

    if (inputElement) {
        inputElement.value = ''; // Reset the file input
        updateLabel(inputElement, "Choose File"); // Reset the label
        delete uploadedFiles[inputId]; // Remove the file from the uploadedFiles object
    }

    previewElement.src = ''; // Clear the PDF preview
    $('#pdfModal').modal('hide'); // Hide the modal
}

function updateLabel(input, labelText) {
    const label = input.closest('.file-upload').querySelector('label[for="' + input.id + '"]');
    if (label) {
        label.textContent = labelText;
    }
}

document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('click', (e) => {
        const inputId = input.id;
        if (uploadedFiles[inputId]) {
            // Prevent file upload dialog when a file is already uploaded
            e.preventDefault();
            previewPDF(input, inputId);
        }
    });
    input.addEventListener('change', (e) => {
        if (input.files.length > 0) {
            updateLabel(input, "File Uploaded");
        }
    });
});
