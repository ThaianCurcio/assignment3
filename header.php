<?php 
if(session_status() === PHP_SESSION_NONE) {
    // Start or resume the session if it's not already active
    session_start();
}
?>

<?php include 'config/dbconfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Session</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>

                    <?php
                    // Dynamically change the "Register", "Member", or "Logout" link based on login status
                    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                        echo '<li><a href="member.php">Member</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } elseif (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
                        echo '<li><a href="register.php">Register</a></li>';
                        echo '<li><a href="index.php">Logout</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>
    </div>
</body>
</html>
