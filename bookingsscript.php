<?php
// Include the database connection file
require 'db_connect.php'; // This file contains the database connection logic

// Fetch all bookings from the database
$stmt = $conn->query("SELECT bookings.*, Active_workers.name AS provider_name FROM bookings JOIN Active_workers ON bookings.provider_id = Active_workers.id ORDER BY booking_date DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table {
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-5">All Bookings</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Provider Name</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Booking Date</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['provider_name']; ?></td>
                        <td><?php echo $booking['customer_name']; ?></td>
                        <td><?php echo $booking['customer_email']; ?></td>
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td><?php echo $booking['notes']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>