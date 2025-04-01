<?php
session_start();

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
$email = trim($_POST['email']);
$password = $_POST['password'];

// Check in service_providers table
$stmt = $conn->prepare("SELECT id, first_name, password FROM companyregistration WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $first_name, $hashed_password);

if ($stmt->fetch() && password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['first_name'] = $first_name;
    header("Location: providerdashboard.php");
    exit();
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$conn->close();
?>