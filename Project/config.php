<?php
$host = 'localhost'; 
$username = 'root';
$password = '';
$database = 'user_db';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}
?>  