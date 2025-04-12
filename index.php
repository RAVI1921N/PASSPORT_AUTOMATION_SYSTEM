<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Passport Automation</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #1e3c72, #2a5298);
            color: #fff;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 30px;
            text-align: center;
            width: 350px;
        }
        .card h2 {
            font-size: 26px;
            margin-bottom: 20px;
        }
        .btn {
            margin: 5px;
            width: 100%;
            background-color: #2a5298;
            border: none;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn:hover {
            background-color: #1e3c72;
            transform: translateY(-3px);
        }
        .btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="apply.php" class="btn btn-primary">Apply for Passport</a>
        <a href="status.php" class="btn btn-info">Check Status</a>
        <a href="appointment.php" class="btn btn-warning">Book Appointment</a>
        <a href="view_appointments.php" class="btn btn-secondary">View Appointments</a>
        <a href="upload.php" class="btn btn-success">Upload Document</a>
        <a href="view_documents.php" class="btn btn-info">View Documents</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
