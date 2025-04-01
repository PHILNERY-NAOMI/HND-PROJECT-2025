<?php
// Database connection
$host = 'localhost';
$db = 'Account';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$address = trim($_POST['address']);
$phone_number = trim($_POST['phone_number']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate password
if ($password !== $confirm_password) {
    die("Error: Passwords do not match.");
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into users table
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, address, phone_number, email, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $first_name, $last_name, $address, $phone_number, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful! Redirecting to login...";
    header("Refresh: 2; URL=user_login.html");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>