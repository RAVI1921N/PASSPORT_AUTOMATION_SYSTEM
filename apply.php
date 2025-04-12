<?php
session_start();
include 'config.php';

// Check if the user is logged in and the user ID is set
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    echo "User ID not set!";
    header("Location: login.php");
    exit;
}

// Function to generate a valid passport number
function generatePassportNumber($countryCode = "IN") {
    $digits = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    return $countryCode . $digits;
}

// Handle passport application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $nationality = $_POST['nationality'];
    $passport_number = generatePassportNumber();  // ✅ Generate passport number

    $stmt = $conn->prepare("INSERT INTO passport_applications (user_id, full_name, dob, address, nationality, passport_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $full_name, $dob, $address, $nationality, $passport_number);

    if ($stmt->execute()) {
        $message = "Application Submitted Successfully!";
        header("Location: index.php");
        exit;
    } else {
        $message = "Error Submitting Application: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Passport</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
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
            width: 350px;
        }
        .card h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .btn-apply {
            width: 100%;
            padding: 12px;
            background-color: #4e54c8;
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn-apply:hover {
            background-color: #3b42a4;
            transform: translateY(-3px);
        }
        .message {
            margin-top: 15px;
            font-weight: bold;
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Passport Application</h2>
        <?php if (isset($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <form method="post">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter Full Name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" placeholder="Enter Address" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Nationality</label>
                <input type="text" name="nationality" placeholder="Enter Nationality" class="form-control" required>
            </div>
            <button type="submit" class="btn-apply">Apply for Passport</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
