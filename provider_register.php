<?php
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
    // Retrieve and sanitize form data
    $company_name = htmlspecialchars($_POST['company_name']);
    $manager_name = htmlspecialchars($_POST['manager_name']);
    $town = htmlspecialchars($_POST['town']);
    $country = htmlspecialchars($_POST['country']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    try {
        $stmt = $conn->prepare("INSERT INTO company_registration (company_name, manager_name, town, country, email, password) VALUES (:company_name, :manager_name, :town, :country, :email, :password)");
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':manager_name', $manager_name);
        $stmt->bindParam(':town', $town);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        // Redirect to the login page after successful registration
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>