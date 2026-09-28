<?php

include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    // Check passwords
    if ($password !== $confirm_password) {

        $message = "❌ Passwords do not match!";

    } else {

        // Check if email already exists
        $check_email = "SELECT id FROM users WHERE email = ?";

        $stmt = $conn->prepare($check_email);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows > 0) {

            $message = "❌ This email is already registered!";

        } else {

            // Secure password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $sql = "INSERT INTO users (name, email, password, role)
                    VALUES (?, ?, ?, 'member')";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashed_password
            );


            if ($stmt->execute()) {

                $message = "✅ Registration successful! You can now login.";

            } else {

                $message = "❌ Something went wrong. Please try again.";

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

    <title>Register - Public Library</title>

    <link rel="stylesheet" href="css/style.css">
     <script src="js/script.js"></script>

</head>

<body>

    <!-- Header -->
    <header>

        <div class="logo">
            <span>📖</span>
            <h1>Public Library</h1>
        </div>

        <p>Your cozy little corner of knowledge & stories ✨</p>

    </header>


    <!-- Navigation -->
    <nav>

        <a href="index.php">Home</a>
        <a href="books.php">Books</a>
        <a href="membership.php">Membership</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="contact.php">Contact</a>

    </nav>


    <!-- Registration -->
    <main class="form-container">

        <div class="form-card">

            <div class="form-icon">
                📚
            </div>

            <h2>Create Your Library Account</h2>
            <?php if ($message != ""): ?>

    <div class="form-message">
        <?php echo $message; ?>
    </div>

<?php endif; ?>

            <p class="form-subtitle">
                Join our little reading community 🌿
            </p>


            <form action="register.php" method="POST">

                <!-- Name -->
                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>


                <!-- Email -->
                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <!-- Password -->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        required
                    >

                </div>


                <!-- Confirm Password -->
                <div class="form-group">

                    <label for="confirm_password">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        required
                    >

                </div>


                <button type="submit" class="register-btn">
                    🌿 Create Account
                </button>

            </form>


            <p class="login-text">
                Already have an account?
                <a href="login.php">Login here</a>
            </p>

        </div>

    </main>


    <!-- Footer -->
    <footer>

        <div class="footer-book">
            📖
        </div>

        <h3>Public Library</h3>

        <p>
            Read • Discover • Learn • Grow
        </p>

        <div class="footer-line"></div>

        <small>
            © 2026 Public Library
        </small>

    </footer>

</body>

</html>