<?php
include 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    // Test Case TC_16: Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }

    // Test Case TC_17: Enforce minimum password length (6 characters)
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long!";
    }

    // Test Case TC_18: Restrict username length (max 50 characters)
    if (strlen($username) > 50) {
        $errors[] = "Username must not exceed 50 characters!";
    }

    // Check if username already exists (Prevents duplicate registrations)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "Username already taken!";
    }
    $stmt->close();

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashedPassword, $fullname, $email);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
        } else {
            $errors[] = "Error in registration. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passport Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #3498db, #8e44ad);
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
        }
        .card-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
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
            background-color: #8e44ad;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #3498db;
        }
        .login-link {
            margin-top: 15px;
            text-align: center;
        }
        .login-link a {
            color: #ffdd57;
            text-decoration: none;
            transition: color 0.3s;
        }
        .login-link a:hover {
            color: #ffe680;
        }
        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 400px;">
        <div class="card-header">Passport Registration</div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter Username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="Enter Full Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <div class="login-link">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
