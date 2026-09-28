<?php

session_start();

include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];


    // Find user by email
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();


    // Check if email exists
    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();


        // Check password
        if (password_verify($password, $user["password"])) {

            // Store user information in session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_role"] = $user["role"];

            $message = "✅ Login successful! Welcome, " . $user["name"] . " 📚";

        } else {

            $message = "❌ Incorrect password!";

        }

    } else {

        $message = "❌ No account found with this email!";

    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Public Library</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- HEADER -->

    <header class="site-header">

        <div class="header-content">

            <div class="library-title">
                📖 <span>Public Library</span>
            </div>

            <p>Your cozy little corner of knowledge & stories ✨</p>

        </div>

    </header>


    <!-- NAVIGATION -->

    <nav class="navbar">

        <a href="index.php">Home</a>

        <a href="#">Books</a>

        <a href="#">Membership</a>

        <a href="login.php">Login</a>

        <a href="register.php">Register</a>

        <a href="#">Contact</a>

    </nav>


    <!-- LOGIN FORM -->

    <main>

        <div class="form-container">

            <div class="form-card">

                <div class="form-icon">
                    🔐
                </div>

                <h2>Welcome Back!</h2>

<p class="form-subtitle">
    Login to your library account 📚
</p>

<?php if ($message != ""): ?>

    <div class="form-message">
        <?php echo $message; ?>
    </div>

<?php endif; ?>

<form action="" method="POST">


                <form action="" method="POST">

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


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >

                    </div>


                    <button type="submit" class="register-btn">
                        🔑 Login
                    </button>

                </form>


                <p class="login-text">

                    Don't have an account?

                    <a href="register.php">
                        Create Account
                    </a>

                </p>

            </div>

        </div>

    </main>


    <!-- FOOTER -->

    <footer>

        <p>© 2026 Public Library | Made with 📚 & 💚</p>

    </footer>

</body>

</html>