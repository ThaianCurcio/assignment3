<?php require_once 'templates/header.php'; ?>

<?php
session_start();

// Check if user is not logged in, redirect to index.php
if (!isset($_SESSION['firstname']) || !isset($_SESSION['lastname']) || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get user's full name and email address from session
$fullname = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/style.css"> 
<body>

<h1>Welcome, <?php echo $fullname; ?>!</h1>
<p>Your email address: <?php echo $email; ?></p>

<img src="welcome_image.jpg" alt="Welcome Image">
<p>Thank you for joining our community. We're glad to have you as a member!</p>
<p>Feel free to explore our website and enjoy exclusive benefits.</p>

</body>
</html>
