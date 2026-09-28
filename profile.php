<?php

session_start();

include "config/database.php";


// Check if user is logged in
if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


// Get logged-in user's ID
$user_id = $_SESSION["user_id"];


// Get user information
$sql = "SELECT * FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();


// Member since
if (!empty($user["created_at"]) && $user["created_at"] != "1970-01-01 00:00:00") {

    $member_since = date("d M Y", strtotime($user["created_at"]));

} else {

    $member_since = "Recently Joined";

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | Public Library</title>

    <link rel="stylesheet" href="css/style.css">


    <style>

        /* =========================================
           PROFILE PAGE
           ========================================= */

        .profile-wrapper {

            min-height: 600px;

            padding: 60px 20px;

            display: flex;

            justify-content: center;

            align-items: flex-start;

            background-color: #F7F3EA;

        }


        .profile-card {

            width: 100%;

            max-width: 600px;

            background-color: #FFFDF8;

            padding: 45px;

            border-radius: 25px;

            border: 1px solid #E3D7C3;

            box-shadow: 0 10px 30px rgba(35, 79, 61, 0.12);

            text-align: center;

        }


        .big-profile-icon {

            width: 90px;

            height: 90px;

            margin: 0 auto 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            background-color: #E9F0E8;

            border: 2px solid #B68B40;

            border-radius: 50%;

            font-size: 42px;

        }


        .profile-card h2 {

            margin: 0;

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 32px;

        }


        .profile-welcome {

            margin: 8px 0 30px;

            color: #777;

            font-size: 15px;

        }


        .profile-details {

            text-align: left;

            border-top: 1px solid #E3D7C3;

        }


        .profile-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 17px 5px;

            border-bottom: 1px solid #E3D7C3;

        }


        .profile-label {

            color: #666;

            font-size: 15px;

        }


        .profile-value {

            color: #234F3D;

            font-weight: bold;

            font-size: 15px;

            text-align: right;

        }


        .logout-btn {

            display: inline-block;

            margin-top: 30px;

            padding: 13px 35px;

            background-color: #234F3D;

            color: white;

            border-radius: 30px;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;

        }


        .logout-btn:hover {

            background-color: #183B2D;

            transform: translateY(-2px);

        }


        @media (max-width: 600px) {

            .profile-card {

                padding: 30px 20px;

            }

            .profile-row {

                flex-direction: column;

                align-items: flex-start;

                gap: 5px;

            }

            .profile-value {

                text-align: left;

            }

        }

    </style>

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

        <a href="contact.php">Contact</a>

    </nav>


    <!-- Profile Section -->

    <main class="profile-wrapper">

        <div class="profile-card">


            <div class="big-profile-icon">

                👤

            </div>


            <h2>My Profile</h2>


            <p class="profile-welcome">

                Welcome,

                <?php echo htmlspecialchars($user["name"]); ?>

               ! 🌿

            </p>


            <div class="profile-details">


                <div class="profile-row">

                    <span class="profile-label">

                        👤 Name

                    </span>

                    <span class="profile-value">

                        <?php echo htmlspecialchars($user["name"]); ?>

                    </span>

                </div>


                <div class="profile-row">

                    <span class="profile-label">

                        📧 Email

                    </span>

                    <span class="profile-value">

                        <?php echo htmlspecialchars($user["email"]); ?>

                    </span>

                </div>


                <div class="profile-row">

                    <span class="profile-label">

                        📚 Account Type

                    </span>

                    <span class="profile-value">

                        <?php echo ucfirst(htmlspecialchars($user["role"])); ?>

                    </span>

                </div>


                <div class="profile-row">

                    <span class="profile-label">

                        📅 Member Since

                    </span>

                    <span class="profile-value">

                        <?php echo $member_since; ?>

                    </span>

                </div>


            </div>


            <a href="logout.php" class="logout-btn">

                🚪 Logout

            </a>


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

            © 2026 Public Library | Library Membership Management System

        </small>

    </footer>


</body>

</html>