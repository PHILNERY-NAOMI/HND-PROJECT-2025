<?php
session_start();

// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'account'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Create a connection to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Fetch user data from the database
    try {
        $stmt = $conn->prepare("SELECT id, company_name, password FROM company_registration WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Debugging: Print the fetched user data
            echo "<pre>";
            print_r($user);
            echo "</pre>";

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['company_name'] = $user['company_name'];

            // Debugging: Print the session data
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Display error message
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>