<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: provider_login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'Account';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get form data
$yourName = $_POST['yourName'] ?? '';
$companyName = $_POST['companyName'] ?? '';
$serviceName = $_POST['serviceName'] ?? '';
$address = $_POST['address'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$estimatedHours = $_POST['estimatedHours'] ?? 0;
$paymentMethod = $_POST['paymentMethod'] ?? '';
$totalAmount = $_POST['totalAmount'] ?? 0;
$preferredDate = $_POST['preferredDate'] ?? '';
$preferredTime = $_POST['preferredTime'] ?? '';
$message = $_POST['message'] ?? '';

// Insert into user_bookings
$sql = "INSERT INTO user_bookings (
    user_id, your_name, company_name, service_name, address, telephone, 
    estimated_hours, payment_method, total_amount, 
    preferred_date, preferred_time, message
) VALUES (
    :user_id, :your_name, :company_name, :service_name, :address, :telephone,
    :estimated_hours, :payment_method, :total_amount,
    :preferred_date, :preferred_time, :message
)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id']);
$stmt->bindValue(':your_name', $yourName);
$stmt->bindValue(':company_name', $companyName);
$stmt->bindValue(':service_name', $serviceName);
$stmt->bindValue(':address', $address);
$stmt->bindValue(':telephone', $telephone);
$stmt->bindValue(':estimated_hours', $estimatedHours);
$stmt->bindValue(':payment_method', $paymentMethod);
$stmt->bindValue(':total_amount', $totalAmount);
$stmt->bindValue(':preferred_date', $preferredDate);
$stmt->bindValue(':preferred_time', $preferredTime);
$stmt->bindValue(':message', $message);

if ($stmt->execute()) {
    header("Location: user_dashboard.php?booking_success=1");
} else {
    header("Location: booking_form.php?error=1");
}
exit();