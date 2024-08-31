<?php
$servername = "localhost";
$username = "root";  // Change as per your database settings
$password = "";  // Change as per your database settings
$dbname = "BMI_PHP_APP";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
