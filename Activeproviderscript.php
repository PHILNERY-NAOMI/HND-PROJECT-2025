<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: provider_login.php");
    exit();
}

$company_name = isset($_SESSION['company_name']) ? $_SESSION['company_name'] : '';

// Database connection
$host = 'localhost';
$dbname = 'Account';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider_name = $_POST['provider_name'];
    $location = $_POST['Location'];
    $services = implode(', ', $_POST['service_category']);
    $work_photo = '';

    // Handle file upload
    if (isset($_FILES['work_photo']) && $_FILES['work_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $work_photo = $upload_dir . basename($_FILES['work_photo']['name']);
        move_uploaded_file($_FILES['work_photo']['tmp_name'], $work_photo);
    }

    // Insert data into the active_providers table
    $stmt = $conn->prepare("INSERT INTO active_providers (company_name, provider_name, location, services, work_photo) VALUES (:company_name, :provider_name, :location, :services, :work_photo)");
    $stmt->execute([
        ':company_name' => $company_name,
        ':provider_name' => $provider_name,
        ':location' => $location,
        ':services' => $services,
        ':work_photo' => $work_photo
    ]);

    // Display a success message
    echo "<script>alert('Provider details added successfully!');</script>";
}
?>