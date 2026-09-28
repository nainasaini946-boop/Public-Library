<?php

session_start();

include "config/database.php";


// Check if user is logged in
if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION["user_id"];


// Get current membership
$sql = "SELECT 
            memberships.id,
            memberships.start_date,
            memberships.expiry_date,
            memberships.status,
            membership_plans.plan_name,
            membership_plans.duration_months,
            membership_plans.price,
            membership_plans.description
        FROM memberships

        INNER JOIN membership_plans
        ON memberships.plan_id = membership_plans.id

        WHERE memberships.user_id = ?

        ORDER BY memberships.id DESC

        LIMIT 1";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$membership = $result->fetch_assoc();


// Get all membership plans
$plans_sql = "SELECT * FROM membership_plans ORDER BY price ASC";

$plans_result = $conn->query($plans_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Membership | Public Library</title>

    <link rel="stylesheet" href="css/style.css">


    <style>

        /* =========================================
           MEMBERSHIP PAGE
           ========================================= */

        .membership-wrapper {

            min-height: 650px;

            padding: 50px 20px;

            background-color: #F7F3EA;

        }


        .membership-container {

            width: 90%;

            max-width: 1000px;

            margin: auto;

        }


        .membership-heading {

            text-align: center;

            margin-bottom: 35px;

        }


        .membership-heading h2 {

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 34px;

            margin-bottom: 8px;

        }


        .membership-heading p {

            color: #777;

        }


        /* Current Membership */

        .current-membership {

            background-color: #234F3D;

            color: white;

            padding: 35px;

            border-radius: 22px;

            margin-bottom: 45px;

            box-shadow: 0 10px 25px rgba(35, 79, 61, 0.15);

        }


        .current-membership h3 {

            margin-top: 0;

            color: #F5EAD8;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 24px;

        }


        .current-plan {

            font-size: 32px;

            font-family: Georgia, "Times New Roman", serif;

            margin: 10px 0;

        }


        .membership-info {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 15px;

            margin-top: 25px;

        }


        .membership-info-box {

            background-color: rgba(255, 255, 255, 0.10);

            padding: 18px;

            border-radius: 12px;

        }


        .membership-info-box span {

            display: block;

            color: #D8CBB5;

            font-size: 13px;

            margin-bottom: 5px;

        }


        .membership-info-box strong {

            font-size: 15px;

        }


        .active-status {

            color: #DDF0D8;

        }


        /* Plans */

        .plans-heading {

            text-align: center;

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 28px;

            margin-bottom: 25px;

        }


        .plans-grid {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 22px;

        }


        .plan-card {

            background-color: #FFFDF8;

            border: 1px solid #E3D7C3;

            border-radius: 20px;

            padding: 30px 22px;

            text-align: center;

            box-shadow: 0 8px 20px rgba(35, 79, 61, 0.08);

            transition: 0.3s;

        }


        .plan-card:hover {

            transform: translateY(-5px);

            box-shadow: 0 12px 25px rgba(35, 79, 61, 0.13);

        }


        .plan-card h3 {

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 24px;

            margin-bottom: 10px;

        }


        .plan-price {

            color: #B68B40;

            font-size: 30px;

            font-weight: bold;

        }


        .plan-duration {

            color: #777;

            margin: 5px 0 15px;

        }


        .plan-description {

            color: #666;

            font-size: 14px;

            min-height: 40px;

        }


        .upgrade-btn {

            display: inline-block;

            margin-top: 18px;

            padding: 10px 25px;

            background-color: #234F3D;

            color: white;

            border-radius: 25px;

            text-decoration: none;

            font-weight: bold;

        }


        .upgrade-btn:hover {

            background-color: #183B2D;

        }


        .current-plan-badge {

            display: inline-block;

            margin-top: 18px;

            padding: 10px 20px;

            background-color: #E9F0E8;

            color: #234F3D;

            border-radius: 25px;

            font-weight: bold;

        }


        @media (max-width: 800px) {

            .membership-info {

                grid-template-columns: repeat(2, 1fr);

            }

            .plans-grid {

                grid-template-columns: 1fr;

            }

        }


        @media (max-width: 500px) {

            .membership-info {

                grid-template-columns: 1fr;

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


    <?php if (!isset($_SESSION["user_id"])): ?>

        <a href="login.php">Login</a>

        <a href="register.php">Register</a>

    <?php endif; ?>


    <a href="contact.php">Contact</a>

</nav>


    <!-- Membership -->

    <main class="membership-wrapper">

        <div class="membership-container">


            <div class="membership-heading">

                <h2>💳 My Membership</h2>

                <p>Manage your library membership and explore available plans.</p>

            </div>


            <?php if ($membership): ?>


                <section class="current-membership">

                    <h3>🌿 Your Current Membership</h3>


                    <div class="current-plan">

                        <?php echo htmlspecialchars($membership["plan_name"]); ?>

                        Membership

                    </div>


                    <p>

                        <?php echo htmlspecialchars($membership["description"]); ?>

                    </p>


                    <div class="membership-info">


                        <div class="membership-info-box">

                            <span>💰 Price</span>

                            <strong>

                                ₹<?php echo number_format($membership["price"], 2); ?>

                            </strong>

                        </div>


                        <div class="membership-info-box">

                            <span>⏳ Duration</span>

                            <strong>

                                <?php echo $membership["duration_months"]; ?> Months

                            </strong>

                        </div>


                        <div class="membership-info-box">

                            <span>📅 Start Date</span>

                            <strong>

                                <?php echo date("d M Y", strtotime($membership["start_date"])); ?>

                            </strong>

                        </div>


                        <div class="membership-info-box">

                            <span>📅 Expiry Date</span>

                            <strong>

                                <?php echo date("d M Y", strtotime($membership["expiry_date"])); ?>

                            </strong>

                        </div>


                    </div>


                    <p class="active-status">

                        ✓ Status:

                        <?php echo htmlspecialchars($membership["status"]); ?>

                    </p>


                </section>


            <?php else: ?>


                <section class="current-membership">

                    <h3>🌿 No Active Membership</h3>

                    <p>

                        You don't currently have a membership.

                        Choose a plan below to get started.

                    </p>

                </section>


            <?php endif; ?>


            <!-- Plans -->

            <h2 class="plans-heading">

                ✨ Available Membership Plans

            </h2>


            <div class="plans-grid">


                <?php while ($plan = $plans_result->fetch_assoc()): ?>


                    <div class="plan-card">


                        <h3>

                            <?php echo htmlspecialchars($plan["plan_name"]); ?>

                        </h3>


                        <div class="plan-price">

                            ₹<?php echo number_format($plan["price"], 0); ?>

                        </div>


                        <div class="plan-duration">

                            <?php echo $plan["duration_months"]; ?> Months

                        </div>


                        <p class="plan-description">

                            <?php echo htmlspecialchars($plan["description"]); ?>

                        </p>


                        <?php if (

                            $membership &&

                            $plan["id"] == $membership["plan_id"]

                        ): ?>


                            <span class="current-plan-badge">

                                ✓ Current Plan

                            </span>


                        <?php else: ?>


                            <a href="#" class="upgrade-btn">

                                Upgrade

                            </a>


                        <?php endif; ?>


                    </div>


                <?php endwhile; ?>


            </div>


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