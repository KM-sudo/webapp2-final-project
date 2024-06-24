<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <link rel="stylesheet" href="postdetails.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: monospace;
            background: linear-gradient(120deg, #77b9e5, #8e44ad);
            background: url('steps.svg');
            background-size: cover; 
            background-repeat: no-repeat;
            height: 100vh;
            width: 100vw;
            animation: waves 5s infinite alternate;
        }
        @keyframes waves {
            from{
                background-position: 0 0;
            }
            to {
                background-position: 10% 10%;
            }
        }

        .post-container {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid black;
            background: white;
            border-radius: 10px;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .post-container h1 {
            text-align: center;
            padding: 0 0 20px 0;
            border-bottom: 2px solid #adadad;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9ff;
            cursor: pointer;
        }

        li:hover {
            background-color: #f0f0f0;
        }

        input[type="submit"] {
            text-align: center;
            width: 30%;
            height: 50px;
            border: 1px solid;
            background: #2691d9;
            border-radius: 25px;
            font-size: 20px;
            color: #e9f4fb;
            font-weight: 700;
            cursor: pointer;
            outline: none;
            margin: 20px 0 20px 70%;
        }
    </style>
</head>
<body>
<div class="post-container">
        <h1>Post Page</h1>
        <div id="postDetails"></div>
        <?php

        require 'config.php';

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            $pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }

        // Ensure post ID is provided and valid
        $postId = $_GET['id'] ?? null;

         if ($postId === null || !is_numeric($postId) || $postId > 10) {
             echo "No post found with ID " . htmlspecialchars($postId) . "!";
        } else {
             $query = "SELECT * FROM `posts` WHERE id = :id";
             $statement = $pdo->prepare($query);
             $statement->execute([':id' => $postId]);
 
             $post = $statement->fetch(PDO::FETCH_ASSOC);
 
             if ($post) {
                 echo '<h3>Title: ' . htmlspecialchars($post['title']) . '</h3>';
                 echo '<p>Body: ' . htmlspecialchars($post['body']) . '</p>';
                 
             } else {
                 echo "No post found with ID " . htmlspecialchars($postId) . "!";
             }
        }
        ?>
        <form action="posts.php" method="get">
            <input type="submit" id="return" value="Return Back">
        </form>
</div>
</body>
</html>
