<?php
require 'config.php'; // Include database connection file

// Get BookID from URL (e.g., book_details.php?BookID=1)
$book_id = isset($_GET['BookID']) ? (int) $_GET['BookID'] : 0;

$sql = "SELECT * FROM BOOK_DETAILS WHERE BookID = $book_id";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($result);

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?> - Book Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .book-container {
            max-width: 850px;
            background-color: #16213e;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            gap: 20px;
            position: relative;
        }
        .exit-button {
            position: absolute;
            top: 15px;
            right: 15px;
            text-decoration: none;
            font-size: 20px;
            color: #333;
            background: #f8d7da;
            padding: 5px 12px;
            border-radius: 50%;
            font-weight: bold;
            transition: 0.3s;
        }
        .exit-button:hover {
            background: #dc3545;
            color: white;
        }
        .book-cover {
            width: 200px;
            height: 300px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book-details {
            flex: 1;
        }
        .book-title {
            font-size: 26px;
            color: yellow;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .book-author, .book-published, .book-genre {
            color: lightyellow;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .book-synopsis {
            margin-top: 38px;
            font-size: 15px;
            color: silver;
            line-height: 1.3;
        }

            
        @media (max-width: 768px) {
            .book-container {
                flex-direction: column;
                align-items: center;
                text-align: left;
            }
            .book-cover {
                width: 180px;
                height: 270px;
            }
            .exit-button {
                top: 10px;
                right: 10px;
            }
        }

        @media (min-width: 0px){
            .book-container {
                width:90%;
        }
    }

        @media (min-width: 768px) {
            .book-container {
                width: 70%;
            }
        }
    </style>
</head>
<body>

<div class="book-container">
    <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'libary.php' ?>" class="exit-button">✖</a>
    <img src="<?= htmlspecialchars($book['Image']) ?>" alt="<?= htmlspecialchars($book['Title']) ?>" class="book-cover">
    <div class="book-details">
        <h1 class="book-title"><?= htmlspecialchars($book['Title']) ?></h1>
        <p class="book-author"><strong>Author:</strong> <?= htmlspecialchars($book['Author']) ?></p>
        <p class="book-published"><strong>Published Date:</strong> <?= htmlspecialchars($book['Published_Date']) ?></p>
        <p class="book-genre"><strong>Genre:</strong> <?= htmlspecialchars($book['Genre']) ?></p>

        <p class="book-synopsis">
            Synopsis:
            <br><br>
            <?= nl2br(htmlspecialchars($book['Synopsis'])) ?>
        </p>
    </div>
</div>
</body>
</html>