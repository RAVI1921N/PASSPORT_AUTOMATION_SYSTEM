<?php
session_start();
include 'config.php';

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginInput = trim($_POST['loginInput']);
    $password = trim($_POST['password']);

    // Prevent login attempts for 5 minutes if exceeded
    if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_attempt_time']) < 300) {
        echo "<script>alert('Too many failed attempts. Try again later!');</script>";
    } else {
        if (empty($loginInput) || empty($password)) {
            echo "<script>alert('All fields are required!');</script>";
        } elseif (!preg_match("/^[a-zA-Z0-9_@.]+$/", $loginInput)) {
            echo "<script>alert('Invalid characters in username!');</script>";
        } else {
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE (username = ? OR email = ?)");
            $stmt->bind_param("ss", $loginInput, $loginInput);
            $stmt->execute();
            $stmt->bind_result($user_id, $db_username, $hashed_password);
            $stmt->fetch();
            $stmt->close();

            if ($user_id && strcasecmp($db_username, $loginInput) === 0 && password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $db_username;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['login_attempts'] = 0; // Reset attempts
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time();
                echo "<script>alert('Invalid credentials!');</script>";
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
    <title>Login - Passport Automation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
        }
        .form-control {
            background-color: transparent;
            border: 1px solid #fff;
            color: #fff;
        }
        .form-control::placeholder {
            color: #ddd;
        }
        .btn-primary {
            background-color: #2a5298;
            border: none;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #1e3c72;
        }
        .login-info {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #ddd;
        }
    </style>
</head>
<body>
    <div class="card" style="width: 350px;">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Username or Email</label>
                    <input type="text" name="loginInput" placeholder="Enter Username or Email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <div class="login-info">You can use either your username or registered email to log in.</div>
            </form>
        </div>
    </div>
</body>
</html>
