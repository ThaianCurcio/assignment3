<?php require_once 'templates/header.php'; ?>

<?php
// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // Change navigation item "Register" to "Logout"
    echo '<script>
            document.getElementById("register").innerHTML = "Logout";
            document.getElementById("register").href = "logout.php";
          </script>';
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $errors = [];
    if (empty($_POST["fullname"])) {
        $errors[] = "Full Name is required";
    } else {
        $fullname = $_POST["fullname"];
    }
    if (empty($_POST["email"])) {
        $errors[] = "Email is required";
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["message"])) {
        $errors[] = "Message is required";
    } else {
        $message = $_POST["message"];
    }

    // If there are no errors, send the email
    if (empty($errors)) {
        $to = "your_email@example.com"; // Replace with your email address
        $subject = "Contact Form Submission";
        $body = "Name: $fullname\nEmail: $email\nMessage: $message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "<p>Your message has been sent successfully!</p>";
        } else {
            echo "<p>Oops! Something went wrong. Please try again later.</p>";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

<h1>Contact Us</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="fullname">Full Name:</label><br>
    <input type="text" id="fullname" name="fullname"><br><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>
    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="4"></textarea><br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
