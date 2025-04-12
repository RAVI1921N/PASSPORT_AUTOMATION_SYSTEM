<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $document_name = $_POST['document_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;

    // Check file type
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($fileType != "pdf" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "png") {
        echo "Only PDF, JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check file size (5MB max)
    if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
        echo "File size should not exceed 5MB.";
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO documents (user_id, document_name, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $document_name, $target_file);
        $stmt->execute();
        echo "<script>alert('Document uploaded successfully!'); window.location.href = 'upload.php';</script>";
    } else {
        echo "Error uploading file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #34a0a4, #168aad);
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Upload Document</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Document Name</label>
                    <input type="text" name="document_name" class="form-control" placeholder="Enter Document Name" required>
                </div>
                <div class="form-group">
                    <label>Choose File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</body>
</html>
