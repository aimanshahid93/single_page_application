<?php
session_start();
$num1 = rand(0, 10);
$num2 = rand(0, 10);
$_SESSION['captcha_solution'] = $num1 + $num2;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to your CSS -->
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="process.php" method="POST">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required minlength="8">

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <label for="captcha">CAPTCHA: What is <?php echo $num1; ?> + <?php echo $num2; ?>?</label>
            <input type="text" id="captcha" name="captcha" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
