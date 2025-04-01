<?php
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
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$user_id = $_SESSION['user_id'];

// Fetch approved bookings for this user
$stmt = $conn->prepare("SELECT * FROM user_bookings WHERE user_id = :user_id AND status = 'Accepted' ORDER BY preferred_date DESC");
$stmt->execute([':user_id' => $user_id]);
$approved_bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Bookings | CaSaFix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="assets/newestlogo.jpg">
    <style>
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 10;
        }
        .badge-accepted {
            background-color: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- [Include your existing sidebar and navbar from dashboard] -->
    
    <div class="main-content">
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i> Approved Bookings</h5>
                <span class="badge bg-primary"><?= count($approved_bookings) ?> Approved</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company</th>
                                <th>Service</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                         <!-- In the table body section of approved_bookings.php -->
<tbody>
    <?php if (count($approved_bookings) > 0): ?>
        <?php foreach ($approved_bookings as $booking): ?>
            <tr>
                <td><?= $booking['id'] ?></td>
                <td><?= htmlspecialchars($booking['company_name']) ?></td>
                <td><?= htmlspecialchars($booking['service_name']) ?></td>
                <td><?= htmlspecialchars($booking['address']) ?></td>
                <td><?= date('M j, Y', strtotime($booking['preferred_date'])) ?></td>
                <td><?= date('h:i A', strtotime($booking['preferred_time'])) ?></td>
                <td><?= number_format($booking['total_amount'], 2) ?> FRS</td>
                <td>
                    <span class="badge badge-accepted">Accepted</span>
                </td>
                <td>
                    <form method="POST" action="mark_completed.php" class="d-inline">
                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-check-circle me-1"></i> Mark Completed
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Keep your existing no bookings row -->
    <?php endif; ?>
</tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>