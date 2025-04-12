<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging Out...</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff6b6b, #f06543);
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
            padding: 50px;
            text-align: center;
            animation: fadeOut 2s ease-in-out forwards;
        }
        .card h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
            margin-top: 15px;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; transform: scale(0.9); }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Logging Out...</h2>
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Redirect after a delay -->
    <script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 2000); // Redirect after 2 seconds
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
