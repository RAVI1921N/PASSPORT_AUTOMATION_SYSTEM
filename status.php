<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT status, passport_number FROM passport_applications WHERE user_id = $user_id");

// Check if the query was successful
if (!$result) {
    die("Error: " . $conn->error);  // Show the error message for debugging
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Passport Status</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #34a0a4, #168aad);
            color: #fff;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 40px;
            text-align: center;
            width: 400px;
        }
        .card h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .status {
            font-size: 22px;
            color: #ffdd57;
            margin: 10px 0;
        }
        .passport-number {
            font-size: 18px;
            color: #e9ecef;
        }
        .no-application {
            font-size: 20px;
            color: #ff6b6b;
            margin: 20px 0;
        }
        .btn-back {
            margin-top: 15px;
            background-color: #168aad;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background-color: #34a0a4;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Passport Status</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="status">Status: <strong><?php echo $row['status']; ?></strong></div>
                <div class="passport-number">Passport Number: <?php echo $row['passport_number']; ?></div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-application">No Passport Application Found!</div>
        <?php endif; ?>
        <a href="index.php" class="btn-back">Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
