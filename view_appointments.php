<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT appointment_date, slot_time, status FROM appointments WHERE user_id = $user_id ORDER BY appointment_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Your Appointments</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date("d-m-Y", strtotime($row['appointment_date'])); ?></td>
                    <td><?php echo $row['slot_time']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Back to Dashboard</a>
</div>
</body>
</html>
