<?php

session_start();

include "config/database.php";


// Check if user is logged in
if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION["user_id"];
echo "<p style='text-align:center; color:red; font-weight:bold;'>
Logged-in User ID: " . $user_id . "
</p>";


// Get books issued to the logged-in user
$sql = "SELECT
            book_issues.id AS issue_id,
            book_issues.issue_date,
            book_issues.due_date,
            book_issues.return_date,
            book_issues.status,

            books.title,
            books.author,
            books.category,
            books.isbn

        FROM book_issues

        INNER JOIN books
        ON book_issues.book_id = books.id

        WHERE book_issues.user_id = ?

        ORDER BY book_issues.issue_date DESC";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Books | Public Library</title>

    <link rel="stylesheet" href="css/style.css">


    <style>

        /* =========================================
           BOOKS PAGE
           ========================================= */

        .books-wrapper {

            min-height: 650px;

            padding: 50px 20px;

            background-color: #F7F3EA;

        }


        .books-container {

            width: 90%;

            max-width: 1100px;

            margin: auto;

        }


        .books-heading {

            text-align: center;

            margin-bottom: 35px;

        }


        .books-heading h2 {

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 34px;

            margin-bottom: 8px;

        }


        .books-heading p {

            color: #777;

        }


        /* Books Grid */

        .books-grid {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 25px;

        }


        .book-card {

            background-color: #FFFDF8;

            border: 1px solid #E3D7C3;

            border-radius: 20px;

            padding: 25px;

            box-shadow: 0 8px 20px rgba(35, 79, 61, 0.08);

            transition: 0.3s;

        }


        .book-card:hover {

            transform: translateY(-5px);

            box-shadow: 0 12px 25px rgba(35, 79, 61, 0.14);

        }


        .book-icon {

            width: 70px;

            height: 70px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 15px;

            background-color: #E9F0E8;

            border-radius: 15px;

            font-size: 38px;

        }


        .book-card h3 {

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 22px;

            margin: 5px 0 8px;

        }


        .book-author {

            color: #777;

            font-size: 14px;

            margin-bottom: 15px;

        }


        .book-info {

            border-top: 1px solid #E3D7C3;

            padding-top: 12px;

        }


        .book-info p {

            margin: 8px 0;

            color: #555;

            font-size: 14px;

        }


        .book-info strong {

            color: #234F3D;

        }


        .book-status {

            display: inline-block;

            margin-top: 12px;

            padding: 7px 15px;

            border-radius: 20px;

            background-color: #E9F0E8;

            color: #234F3D;

            font-size: 13px;

            font-weight: bold;

        }


        /* Empty Books */

        .no-books {

            background-color: #FFFDF8;

            border: 1px solid #E3D7C3;

            border-radius: 22px;

            padding: 50px 30px;

            text-align: center;

            box-shadow: 0 8px 20px rgba(35, 79, 61, 0.08);

        }


        .no-books-icon {

            font-size: 55px;

            margin-bottom: 15px;

        }


        .no-books h3 {

            color: #234F3D;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 25px;

        }


        .no-books p {

            color: #777;

        }


        @media (max-width: 900px) {

            .books-grid {

                grid-template-columns: repeat(2, 1fr);

            }

        }


        @media (max-width: 600px) {

            .books-grid {

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

        <a href="contact.php">Contact</a>

    </nav>


    <!-- Books -->

    <main class="books-wrapper">

        <div class="books-container">


            <div class="books-heading">

                <h2>📚 My Books</h2>

                <p>Books currently issued to your library account.</p>

            </div>


            <?php if ($result->num_rows > 0): ?>


                <div class="books-grid">


                    <?php while ($book = $result->fetch_assoc()): ?>


                        <div class="book-card">


                            <div class="book-icon">

                                📕

                            </div>


                            <h3>

                                <?php echo htmlspecialchars($book["title"]); ?>

                            </h3>


                            <p class="book-author">

                                ✍️ By

                                <?php echo htmlspecialchars($book["author"]); ?>

                            </p>


                            <div class="book-info">


                                <p>

                                    📂 <strong>Category:</strong>

                                    <?php echo htmlspecialchars($book["category"]); ?>

                                </p>


                                <p>

                                    📅 <strong>Issued:</strong>

                                    <?php

                                    echo date(
                                        "d M Y",
                                        strtotime($book["issue_date"])
                                    );

                                    ?>

                                </p>


                                <p>

                                    ⏰ <strong>Due:</strong>

                                    <?php

                                    echo date(
                                        "d M Y",
                                        strtotime($book["due_date"])
                                    );

                                    ?>

                                </p>


                                <?php if ($book["return_date"]): ?>

                                    <p>

                                        🔄 <strong>Returned:</strong>

                                        <?php

                                        echo date(
                                            "d M Y",
                                            strtotime($book["return_date"])
                                        );

                                        ?>

                                    </p>

                                <?php endif; ?>


                                <span class="book-status">

                                    ✓ <?php echo htmlspecialchars($book["status"]); ?>

                                </span>


                            </div>


                        </div>


                    <?php endwhile; ?>


                </div>


            <?php else: ?>


                <div class="no-books">

                    <div class="no-books-icon">

                        📚

                    </div>

                    <h3>No Books Issued</h3>

                    <p>

                        You currently don't have any books issued

                        from the library.

                    </p>

                </div>


            <?php endif; ?>


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