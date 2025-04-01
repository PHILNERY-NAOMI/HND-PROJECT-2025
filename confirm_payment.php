<?php
session_start();

// Fetch cart data from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

// Calculate the total price
foreach ($cart as $item) {
    $total += $item['price'];
}

// Fetch form data
$name = $_POST['name'];
$id_card = $_POST['id_card'];
$delivery_address = $_POST['delivery_address'];
$home_address = $_POST['home_address'];
$payment_method = $_POST['payment_method'];

// Display confirmation message
echo "<h1>Payment Confirmation</h1>";
echo "<p>Thank you, $name, for your purchase!</p>";
echo "<p>Your payment of " . number_format($total, 0, '.', ',') . " XAF via $payment_method has been processed.</p>";
echo "<p>Your items will be delivered to: $delivery_address</p>";
?>