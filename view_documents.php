<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT document_name, file_path, upload_date FROM documents WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Documents</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #168aad, #34a0a4);
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
            <h2>Uploaded Documents</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>Uploaded On</th>
                        <th>View/Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['document_name']; ?></td>
                            <td><?php echo $row['upload_date']; ?></td>
                            <td><a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn btn-success">View/Download</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
