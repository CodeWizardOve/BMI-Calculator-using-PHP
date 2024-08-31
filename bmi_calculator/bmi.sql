-- Create the database
CREATE DATABASE IF NOT EXISTS BMI_PHP_APP;

-- Use the newly created database
USE BMI_PHP_APP;

-- Create the AppUsers table
CREATE TABLE IF NOT EXISTS AppUsers (
    AppUserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,  
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the BMIUsers table
CREATE TABLE IF NOT EXISTS BMIUsers (
    BMIUserID INT AUTO_INCREMENT PRIMARY KEY,
    AppUserID INT,
    Name VARCHAR(100) NOT NULL,
    Age INT,
    Gender ENUM('Male', 'Female', 'Other'),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AppUserID) REFERENCES AppUsers(AppUserID) ON DELETE CASCADE
);

-- Create the BMIRecords table
CREATE TABLE IF NOT EXISTS BMIRecords (
    RecordID INT AUTO_INCREMENT PRIMARY KEY,
    BMIUserID INT,
    Height FLOAT NOT NULL,
    Weight FLOAT NOT NULL,
    BMI FLOAT NOT NULL,
    RecordedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BMIUserID) REFERENCES BMIUsers(BMIUserID) ON DELETE CASCADE
);

-- Optional: Insert a sample user (for testing purposes)
-- INSERT INTO AppUsers (Username, Password) VALUES ('testuser', '<hashed_password>');
