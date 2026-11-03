<?php
// Update these values to match your local MySQL setup.
$host = 'localhost';
$dbname = 'rideconnect';
$username = 'root';
$password = ''; // XAMPP default is often blank; set your own if needed.

try {
    $pdo = new PDO(
        "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    exit('Database connection failed. Check config/database.php and MySQL.');
}
