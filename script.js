document.addEventListener('DOMContentLoaded', function () {
    // File Upload Validation
    const fileInput = document.querySelector('input[type="file"]');
    fileInput?.addEventListener('change', function () {
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        const fileName = this.value.split('\\').pop();
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            alert('Invalid file type. Please upload a valid file.');
            this.value = ''; // Reset file input
        }
    });

    // Confirmation for Deleting Files
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            if (!confirm('Are you sure you want to delete this file?')) {
                event.preventDefault();
            }
        });
    });
});
