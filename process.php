<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'user_registration'); // Update with your credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullName = $_POST['fullName'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$captcha = $_POST['captcha'];

// Check CAPTCHA
if ($captcha != $_SESSION['captcha_solution']) {
    die("CAPTCHA is incorrect.");
}

// Validate password
if ($password !== $confirmPassword) {
    die("Passwords do not match.");
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare to insert user data
$stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullName, $email, $hashedPassword);

if ($stmt->execute()) {
    // Generate unique token for email confirmation
    $token = bin2hex(random_bytes(32));

    // Store token in the email_confirmations table
    $stmt = $conn->prepare("INSERT INTO email_confirmations (email, token) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();

    // Send confirmation email
    $to = $email;
    $subject = "Email Confirmation";
    $message = "Please confirm your email by clicking the link: http://localhost/single_page_app/confirm.php?token=$token";
    $headers = "From: no-reply@yourdomain.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Registration successful! A confirmation email has been sent.";
    } else {
        echo "Registration successful, but failed to send confirmation email.";
    }
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
