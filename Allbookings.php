<?php
// save_booking.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
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
$company_name = $_POST['company_name'] ?? '';
$service_name = $_POST['service_name'] ?? '';
$address = $_POST['address'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$estimated_hours = $_POST['estimated_hours'] ?? 0;
$payment_method = $_POST['payment_method'] ?? '';
$total_amount = $_POST['total_amount'] ?? 0;
$preferred_date = $_POST['preferred_date'] ?? '';
$preferred_time = $_POST['preferred_time'] ?? '';
$message = $_POST['message'] ?? '';

// Insert into user_bookings
$sql = "INSERT INTO user_bookings (
    user_id, company_name, service_name, address, telephone, 
    estimated_hours, payment_method, total_amount, 
    preferred_date, preferred_time, message
) VALUES (
    :user_id, :company_name, :service_name, :address, :telephone,
    :estimated_hours, :payment_method, :total_amount,
    :preferred_date, :preferred_time, :message
)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id']);
$stmt->bindValue(':company_name', $company_name);
$stmt->bindValue(':service_name', $service_name);
$stmt->bindValue(':address', $address);
$stmt->bindValue(':telephone', $telephone);
$stmt->bindValue(':estimated_hours', $estimated_hours);
$stmt->bindValue(':payment_method', $payment_method);
$stmt->bindValue(':total_amount', $total_amount);
$stmt->bindValue(':preferred_date', $preferred_date);
$stmt->bindValue(':preferred_time', $preferred_time);
$stmt->bindValue(':message', $message);

if ($stmt->execute()) {
    header("Location: user_dashboard.php?booking_success=1");
} else {
    header("Location: booking_form.php?error=1");
}
exit();