<?php
include 'config/dbconfig.php';
session_start();

// Process the registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Initialize the $errors array
    $errors = [];

    // Validate user input
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        // Check if the email already exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $errors[] = "Email already exists, please choose a different one";
        } else {
            // Insert the new user into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $hashed_password]);

            // Set session variables
            $_SESSION['user'] = [
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name
            ];

            // Redirect to member page
            header("Location: member.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once 'templates/header.php'; ?>

    <main class="main-content">
        <h1>Complete your Registration</h1>
        <p>Please fill out the following information to complete your registration:</p>

        <?php if (!empty($errors)): ?>
            <div style="color: red;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" value="<?php echo isset($_POST["first_name"]) ? htmlspecialchars($_POST["first_name"]) : ""; ?>"><br><br>
            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" value="<?php echo isset($_POST["last_name"]) ? htmlspecialchars($_POST["last_name"]) : ""; ?>"><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ""; ?>"><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Register">
        </form>
    </main>

    <?php require_once 'templates/footer.php'; ?>
</body>
</html>
