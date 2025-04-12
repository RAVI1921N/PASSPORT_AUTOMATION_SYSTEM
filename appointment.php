<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $slot_time = $_POST['slot_time'];

    // Check if the slot is already booked
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE appointment_date = ? AND slot_time = ?");
    $stmt->bind_param("ss", $appointment_date, $slot_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Slot available, insert booking
        $stmt = $conn->prepare("INSERT INTO appointments (user_id, appointment_date, slot_time) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $appointment_date, $slot_time);
        if ($stmt->execute()) {
            echo "<script>alert('Appointment booked successfully!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Booking failed! Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('Slot already booked! Please choose another.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff8c00, #ff3e00);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            width: 400px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        .card h2 {
            margin-bottom: 20px;
            font-size: 28px;
        }
        .btn-custom {
            background-color: #ff3e00;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            background-color: #ff8c00;
        }
        .btn-back {
            margin-top: 10px;
            background-color: #555;
            color: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Book Your Appointment</h2>
        <form method="post">
            <div class="form-group">
                <label>Appointment Date</label>
                <input type="date" name="appointment_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Slot Time</label>
                <select name="slot_time" class="form-control" required>
                    <option value="09:00 AM">09:00 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="01:00 PM">01:00 PM</option>
                    <option value="03:00 PM">03:00 PM</option>
                    <option value="05:00 PM">05:00 PM</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Book Appointment</button>
            <a href="index.php" class="btn btn-back btn-block">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
