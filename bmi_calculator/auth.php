<?php
session_start();
require 'config.php';

// Function to check and create tables if they don't exist
function initialize_database() {
    global $conn;

    // Create AppUsers table if it doesn't exist
    $createAppUsersTable = "
    CREATE TABLE IF NOT EXISTS AppUsers (
        AppUserID INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(50) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,  
        CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // Create BMIUsers table if it doesn't exist
    $createBMIUsersTable = "
    CREATE TABLE IF NOT EXISTS BMIUsers (
        BMIUserID INT AUTO_INCREMENT PRIMARY KEY,
        AppUserID INT,
        Name VARCHAR(100) NOT NULL,
        Age INT,
        Gender ENUM('Male', 'Female', 'Other'),
        CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (AppUserID) REFERENCES AppUsers(AppUserID) ON DELETE CASCADE
    )";

    // Create BMIRecords table if it doesn't exist
    $createBMIRecordsTable = "
    CREATE TABLE IF NOT EXISTS BMIRecords (
        RecordID INT AUTO_INCREMENT PRIMARY KEY,
        BMIUserID INT,
        Height FLOAT NOT NULL,
        Weight FLOAT NOT NULL,
        BMI FLOAT NOT NULL,
        RecordedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (BMIUserID) REFERENCES BMIUsers(BMIUserID) ON DELETE CASCADE
    )";

    // Execute the SQL commands
    try {
        $conn->exec($createAppUsersTable);
        $conn->exec($createBMIUsersTable);
        $conn->exec($createBMIRecordsTable);
    } catch (PDOException $e) {
        echo "Error creating tables: " . $e->getMessage();
    }
}

// Initialize the database
initialize_database();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function login($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['AppUserID'];
        $_SESSION['username'] = $user['Username'];
        header("Location: bmi_calculator.php");
        exit();
    } else {
        return "Invalid username or password.";
    }
}

function signup($username, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO AppUsers (Username, Password) VALUES (:username, :password)");
    try {
        $stmt->execute(['username' => $username, 'password' => $hashed_password]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        return "Username already exists.";
    }
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
