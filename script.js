function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthIndicator = document.getElementById('password-strength');
    if (password.length < 8) {
        strengthIndicator.innerText = 'Weak password';
        strengthIndicator.style.color = 'red';
    } else {
        strengthIndicator.innerText = 'Strong password';
        strengthIndicator.style.color = 'green';
    }
}
