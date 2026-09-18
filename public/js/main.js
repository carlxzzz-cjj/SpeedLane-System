document.addEventListener('DOMContentLoaded', function () {
    const trackingForm = document.getElementById('trackingForm');
    const trackingInput = document.getElementById('trackingCode');
    const validationFeedback = document.getElementById('validationFeedback');

    trackingForm.addEventListener('submit', function (event) {
        const codeValue = trackingInput.value.trim();

        // Simple validation rule matching your Figma placeholder string setup
        if (codeValue.length < 5) {
            event.preventDefault(); // Stop form route change
            trackingInput.classList.add('is-invalid');
            validationFeedback.textContent = 'Please enter a valid vehicle tracking reference code.';
        } else {
            trackingInput.classList.remove('is-invalid');
            // Form proceeds natively to /track?trackingCode=...
        }
    });

    // Clear alert classes on keystroke input 
    trackingInput.addEventListener('input', function () {
        if (this.classList.contains('is-invalid')) {
            this.classList.remove('is-invalid');
        }
    });
});