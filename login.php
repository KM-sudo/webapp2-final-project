<?php
    require 'config.php';

    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {
        $pdo = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }


    function handle_login($pdo) {
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            return;
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `users` WHERE username = :username";
        $statement = $pdo->prepare($query);
        $statement->execute([':username' => $username]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === 'secret123') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: posts.php");
            exit;
        } else {
            echo $user ? "Invalid password!" : "User not found!";
        }
    }

    if ($pdo) {
        handle_login($pdo);
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Login form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: monospace;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(120deg, #77b9e5, #8e44ad);
            background: url('haikei.svg');
            background-size: cover; 
            background-repeat: no-repeat;
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
        .login-center {
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            background: white;
            border-radius: 10px;
            box shadow: 0 4px 8px rgba(0, 0,0, .37)
        }
        .login-center h1 {
            text-align: center;
            padding: 0 0 20px 0;
            border-bottom: 1px solid silver;
        }
        .login-center form {
            padding: 0 40px;
            box-sizing: border-box;
        }
        form .txt_field {
            position: relative;
            border-bottom: 2px solid #adadad;
            margin: 30px 0;
        }
        .txt_field input {
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
        }
        .txt_field label {
            position: absolute;
            top: 50%;
            left: 5px;
            color: #adadad;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: .5s;
        }
        .txt_field span::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #2691d9;
            transition: .5s;
        }
        .txt_field input:focus ~ label,
        .txt_field input:valid ~ label {
            top: -5px;
            color: #2691d9;
        }
        .txt_field input:focus ~ span::before,
        .txt_field input:valid ~ span::before {
            width: 100%;
        }
        .pass {
            margin: -5px 0 20px 5px;
            color: #a6a6a6;
            cursor: pointer;
        }
        .pass:hover {
            text-decoration: underline;
        }
        input[type="submit"] {
            width: 100%;
            height: 50px;
            border: 1px solid;
            background: #2691d9;
            border-radius: 25px;
            font-size: 18px;
            color: #e9f4fb;
            font-weight: 700;
            cursor: pointer;
            outline: none;
        }
        input[type="submit"]:hover {
            border-color: #2691d9;
            transition: .5s;
        }
        .signup_link {
            margin: 30px 0;
            text-align: center;
            font-size: 16px;
            color: #666666;
        }
        .signup_link a {
            color: #2691d9;
            text-decoration: none;
        }
        .signup_link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-center">
        <h1>Login</h1>
        <form id="post" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">

            <div class="txt_field">
                <input type="text" id="username" name="username" autocomplete="off" required>
                <span></span>
                <label>Username</label>
            </div>

            <div class="txt_field">
                <input type="password" id="password" name="password" autocomplete="off" required>
                <span></span>
                <label>Password</label>
            </div>

            <div class="pass">Forgot Password?</div>
            <input type="submit" id="submit" value="Login">
            <div class="signup_link">
                Not a member? <a href="#">Signup</a>
            </div>
        </form>
    </div>
        <!-- Include particles.js library -->
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- Configure particles.js -->
    <script>
        particlesJS.load('particles-js', 'particles.json', function() {
            console.log('particles.js loaded - callback');
        });
    </script>
</body>
</html>
