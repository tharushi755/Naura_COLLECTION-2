<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_name']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login_form.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h3>hi, <span>admin</span></h3>
            <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?> (Admin)</h1>
            <p>this is an admin page</p>
            <a href="register_form.php" class="btn">go to home</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
    </div>
</body>
</html>
