document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    const paymentMethods = document.querySelectorAll('.payment-method');
    const creditCardForm = document.getElementById('creditCardForm');

    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            // Remove active class from all methods
            paymentMethods.forEach(m => m.classList.remove('active'));
            // Add active class to selected method
            method.classList.add('active');
            
            // Show/hide credit card form based on selection
            if (method.dataset.method === 'credit-card') {
                creditCardForm.style.display = 'block';
            } else {
                creditCardForm.style.display = 'none';
            }
        });
    });

    // Form validation
    const cardNumberInput = document.getElementById('cardNumber');
    const expiryDateInput = document.getElementById('expiryDate');
    const cvvInput = document.getElementById('cvv');
    const confirmButton = document.querySelector('.confirm-button');

    // Card number formatting
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(.{4})/g, '$1 ').trim();
        e.target.value = value.substring(0, 19); // 16 digits + 3 spaces
    });

    // Expiry date formatting (MM/YY)
    expiryDateInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        e.target.value = value.substring(0, 5);
    });

    // CVV validation
    cvvInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value.substring(0, 3);
    });

    // Show CVV tooltip
    const cvvTooltip = document.querySelector('.cvv-tooltip');
    cvvTooltip.addEventListener('mouseenter', function() {
        this.setAttribute('data-tooltip', 'The 3-digit security code on the back of your card');
    });

    // Form submission
    confirmButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        const selectedMethod = document.querySelector('.payment-method.active');
        if (!selectedMethod) {
            alert('Please select a payment method');
            return;
        }

        if (selectedMethod.dataset.method === 'credit-card') {
            // Validate credit card form
            const cardName = document.getElementById('cardName').value;
            const cardNumber = cardNumberInput.value.replace(/\s/g, '');
            const expiryDate = expiryDateInput.value;
            const cvv = cvvInput.value;

            if (!cardName) {
                alert('Please enter the name on your card');
                return;
            }
            if (cardNumber.length !== 16) {
                alert('Please enter a valid card number');
                return;
            }
            if (!expiryDate.match(/^(0[1-9]|1[0-2])\/([0-9]{2})$/)) {
                alert('Please enter a valid expiry date (MM/YY)');
                return;
            }
            if (cvv.length !== 3) {
                alert('Please enter a valid CVV');
                return;
            }
        }

        // Simulate payment processing
        confirmButton.disabled = true;
        confirmButton.textContent = 'Processing...';
        
        setTimeout(() => {
            alert('Payment successful!');
            confirmButton.disabled = false;
            confirmButton.textContent = 'Confirm and pay';
        }, 2000);
    });
}); 