<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Public Library</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Header -->
    <!-- Header -->
<header>

    <div class="logo">
        <span>📖</span>
        <h1>Public Library</h1>
    </div>

    <p>Your cozy little corner of knowledge & stories ✨</p>


    <!-- Profile Icon - Only visible after login -->
    <?php if (isset($_SESSION["user_id"])): ?>

    <a href="profile.php"
       title="My Profile"
       style="
           position: fixed !important;
           top: 25px !important;
           right: 30px !important;
           width: 50px;
           height: 50px;
           display: flex;
           align-items: center;
           justify-content: center;
           background-color: #FFFDF8;
           border: 2px solid #B68B40;
           border-radius: 50%;
           font-size: 25px;
           text-decoration: none;
           box-shadow: 0 5px 15px rgba(0,0,0,0.15);
           z-index: 99999;
       ">
        👤
    </a>

<?php endif; ?>

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


    <!-- Main Content -->
    <main class="container">


        <!-- Hero Section -->
        <section class="hero">

            <div class="hero-decoration">✦</div>

            <span class="welcome-badge">
                🌿 Welcome, Book Lover!
            </span>

            <h2>
                Where Every Book<br>
                <span>Has a Story to Tell</span>
            </h2>

            <p>
                Discover wonderful books, become a member,
                and find your next favorite story in our
                little library.
            </p>

            <div class="hero-buttons">

                <a href="books.php" class="btn primary-btn">
                    📚 Explore Books
                </a>

                <a href="register.php" class="btn secondary-btn">
                    💚 Join Our Library
                </a>

            </div>

            <div class="floating-book book-one">📕</div>
            <div class="floating-book book-two">📗</div>
            <div class="floating-book book-three">📘</div>

        </section>


        <!-- Services -->
        <section class="services">

            <div class="section-title">

                <span>✿</span>

                <h2>Little Things We Offer</h2>

                <span>✿</span>

            </div>

            <p class="section-subtitle">
                Everything you need for a happy reading experience.
            </p>


            <div class="service-boxes">


                <div class="service-box">

                    <div class="service-icon">
                        📚
                    </div>

                    <h3>Explore Books</h3>

                    <p>
                        Browse our collection and discover
                        books waiting to be explored.
                    </p>

                </div>


                <div class="service-box">

                    <div class="service-icon">
                        🌿
                    </div>

                    <h3>Membership</h3>

                    <p>
                        Become a library member and enjoy
                        easy access to your favorite books.
                    </p>

                </div>


                <div class="service-box">

                    <div class="service-icon">
                        💌
                    </div>

                    <h3>Easy Borrowing</h3>

                    <p>
                        Issue books easily and keep track
                        of your borrowed books.
                    </p>

                </div>


                <div class="service-box">

                    <div class="service-icon">
                        ✨
                    </div>

                    <h3>Simple & Easy</h3>

                    <p>
                        Manage your library activities
                        from one simple place.
                    </p>

                </div>

            </div>

        </section>


        <!-- Quote -->
        <section class="quote-section">

            <div class="quote-icon">
                ❝
            </div>

            <p>
                A good book is like a good friend —
                it stays with you long after the story ends.
            </p>

            <span>— Happy Reading 🌿</span>

        </section>


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