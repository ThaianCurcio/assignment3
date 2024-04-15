<?php
include 'config/dbconfig.php';
session_start();

// Check if user is already logged in, redirect to member page
if (isset($_SESSION['user'])) {
    header("Location: member.php");
    exit();
}

// Initialize the $errors array
$errors = [];

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validate user input
    if (empty($email) || empty($password)) {
        $errors[] = "Both email and password are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        // Check if the email exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // User does not exist
            $errors[] = "Invalid email or password";
        } else {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user'] = [
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name']
                ];
                // Redirect to member page
                header("Location: member.php");
                exit();
            } else {
                // Invalid password
                $errors[] = "Invalid email or password";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to our Website</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Hide the form after successful login */
        <?php if (isset($_SESSION['user'])): ?>
            form {
                display: none;
            }
        <?php endif; ?>
    </style>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>

    <main class="main-content">
        <h1>Welcome to our Website</h1>
        <p>This website provides courses in PHP, Python, Java, and JavaScript. Please login below to access member content.</p>

        <?php if (!isset($_SESSION['user'])): ?>
            <!-- Display form if user is not logged in -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Login">
            </form>

            <!-- Display error messages if any -->
            <?php if (!empty($errors)): ?>
                <div style="color: red;">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>You are logged in as <?php echo $_SESSION['user']['email']; ?>. <a href="logout.php">Logout</a></p>
        <?php endif; ?>

        <div class="course-section">
            <div class="course" id="php">
                <h2>PHP Course</h2>
                <img src="images/php.jpg" alt="PHP Course Image" width = "75%">
                <p>PHP is a popular server-side scripting language. This course covers PHP basics, web development with PHP, and more.</p>
            </div>
            <div class="course" id="python">
                <h2>Python Course</h2>
                <img src="images/python.jpg" alt="Python Course Image" width = "75%">
                <p>Python is a versatile programming language used for web development, data science, artificial intelligence, and more. This course covers Python fundamentals, advanced topics, and practical projects.</p>
            </div>
            <div class="course" id="java">
                <h2>Java Course</h2>
                <img src="images/java.jpg" alt="Java Course Image" width = "75%">
                <p>Java is a powerful, object-oriented programming language. This course covers Java syntax, object-oriented programming concepts, and building applications with Java.</p>
            </div>
            <div class="course" id="javascript">
                <h2>JavaScript Course</h2>
                <img src="images/js.png" alt="JavaScript Course Image" width = "75%">
                <p>JavaScript is a fundamental technology for web development. This course covers JavaScript basics, DOM manipulation, asynchronous programming, and more.</p>
            </div>
        </div>
    </main>

    <?php require_once 'templates/footer.php'; ?>
</body>
</html>
