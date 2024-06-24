<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="post.css">
    <title>Posts Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: monospace;
            background: linear-gradient(120deg, #77b9e5, #8e44ad);
            background: url('steps.svg') no-repeat center center fixed;
            background-size: cover; 
            height: 100vh;
            width: 100vw;
            animation: waves 10s infinite alternate;
        }
        @keyframes waves {
            from{
                background-position: 0 0;
            }
            to {
                background-position: 100% 100%;
            }
        }
        .posts-container {
            background: linear-gradient(120deg, #77b9e5, #8e44ad);
            border-radius: 10px;
            max-width: 800px;
            margin: 60px auto;
            padding: 30px;
            border: 1px solid white;
            border-radius: 10px;
        }
        .posts-container h1 {
            font-size: 40px;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
            font-size: 20px;
            text-align: left;
        }
        li {
            margin-bottom: 10px;
            border: 1px solid silver;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9ff;
            cursor: pointer;
        }
        li a {
            text-decoration: none;
            color: black;
        }
        li:hover {
            background-color: rgb(208, 204, 204);
            transition: 0.5s;
        }
        input[type="submit"] {
            text-align: center;
            width: 20%;
            height: 50px;
            border: 1px solid;
            background: #2691d9;
            border-radius: 25px;
            font-size: 20px;
            color: #e9f4fb;
            font-weight: 700;
            cursor: pointer;
            outline: none;
            margin: 10px 0 0 75%;
        }
    </style>
</head>
<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
        <?php

        require 'config.php';

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            $pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        // Function to retrieve and display posts
        function display_posts($pdo, $user_id) {
            $query = "SELECT * FROM `posts` WHERE user_id = :id";
            $statement = $pdo->prepare($query);
            $statement->execute([':id' => $user_id]);

            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                echo '<li><a href="postdetails.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
            }
        }

        // Call the function to display posts
        if ($pdo) {
            display_posts($pdo, $_SESSION['user_id']);
        }
        ?>
        </ul>
        <form action="logout.php" method="post">
            <input type="submit" value="Logout">
        </form>
    </div>
</body>
</html>
