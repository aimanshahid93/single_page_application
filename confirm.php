<?php
$conn = new mysqli('localhost', 'your_username', 'your_password', 'user_registration');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$token = $_GET['token'];
$stmt = $conn->prepare("SELECT * FROM email_confirmations WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];

    // Update the user's email confirmation status
    $stmt = $conn->prepare("UPDATE users SET email_confirmed = 1 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    echo "Email confirmed successfully!";
} else {
    echo "Invalid token.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
