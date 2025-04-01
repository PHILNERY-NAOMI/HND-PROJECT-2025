<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['company_name'])) {
    header("Location: login.php");
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

$company_name = $_SESSION['company_name'];

// Handle Accept/Reject actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $status = ($_POST['action'] == 'accept') ? 'Accepted' : 'Rejected';
    
    $stmt = $conn->prepare("UPDATE user_bookings SET status = :status WHERE id = :id AND company_name = :company_name");
    $stmt->execute([
        ':status' => $status,
        ':id' => $booking_id,
        ':company_name' => $company_name
    ]);
    
    // Redirect to prevent form resubmission
    header("Location: company_bookings.php");
    exit();
}

// Fetch filter parameters
$filterOption = $_GET['filterOption'] ?? 'all';
$searchInput = $_GET['searchInput'] ?? '';

// Build SQL query
$sql = "SELECT * FROM user_bookings WHERE company_name = :company_name";
$params = [':company_name' => $company_name];

if ($filterOption == 'service') {
    $sql .= " AND service_name LIKE :search";
    $params[':search'] = "%$searchInput%";
} elseif ($filterOption == 'customer') {
    $sql .= " AND your_name LIKE :search";
    $params[':search'] = "%$searchInput%";
} elseif ($filterOption == 'recent') {
    $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
} elseif ($filterOption == 'status') {
    $sql .= " AND status = :status";
    $params[':status'] = $searchInput;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Bookings | CaSaFix</title>
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
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-accepted {
            background-color: #28a745;
            color: #fff;
        }
        .badge-rejected {
            background-color: #dc3545;
            color: #fff;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .btn-accept {
            background-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
        .btn-accept:hover {
            background-color: #218838;
            color: white;
        }
        .btn-reject:hover {
            background-color: #c82333;
            color: white;
        }
    </style>
</head>
<body>
    <!-- [Include your existing sidebar and navbar from dashboard] -->
    
    <div class="main-content">
        <!-- [Your existing header content] -->
        
        <!-- Bookings Section -->
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Company Bookings</h5>
                <span class="badge bg-primary"><?= count($bookings) ?> Bookings</span>
            </div>
            <div class="card-body">
                <!-- Search & Filter -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form method="GET" action="company_bookings.php" class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="searchInput" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($searchInput) ?>">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="filterOption" class="form-select">
                                    <option value="all" <?= $filterOption === 'all' ? 'selected' : '' ?>>All Bookings</option>
                                    <option value="service" <?= $filterOption === 'service' ? 'selected' : '' ?>>By Service</option>
                                    <option value="customer" <?= $filterOption === 'customer' ? 'selected' : '' ?>>By Customer</option>
                                    <option value="recent" <?= $filterOption === 'recent' ? 'selected' : '' ?>>Recent Bookings</option>
                                    <option value="status" <?= $filterOption === 'status' ? 'selected' : '' ?>>By Status</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Bookings Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($bookings) > 0): ?>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><?= $booking['id'] ?></td>
                                        <td><?= htmlspecialchars($booking['your_name']) ?></td>
                                        <td><?= htmlspecialchars($booking['service_name']) ?></td>
                                        <td><?= htmlspecialchars($booking['address']) ?></td>
                                        <td><?= htmlspecialchars($booking['telephone']) ?></td>
                                        <td><?= date('M j, Y', strtotime($booking['preferred_date'])) ?></td>
                                        <td><?= date('h:i A', strtotime($booking['preferred_time'])) ?></td>
                                        <td><?= number_format($booking['total_amount'], 2) ?> FRS</td>
                                        <td>
                                            <?php if (empty($booking['status']) || $booking['status'] === 'Pending'): ?>
                                                <span class="badge badge-pending">Pending</span>
                                            <?php elseif ($booking['status'] === 'Accepted'): ?>
                                                <span class="badge badge-accepted">Accepted</span>
                                            <?php else: ?>
                                                <span class="badge badge-rejected">Rejected</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (empty($booking['status']) || $booking['status'] === 'Pending'): ?>
                                                <form method="POST" action="company_bookings.php" class="action-buttons">
                                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                                    <button type="submit" name="action" value="accept" class="btn btn-sm btn-accept">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <button type="submit" name="action" value="reject" class="btn btn-sm btn-reject">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Action taken</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-calendar-times fa-2x mb-3 text-muted"></i>
                                        <h5>No Bookings Found</h5>
                                        <p class="text-muted">You don't have any bookings yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add confirmation for reject action
        document.addEventListener('DOMContentLoaded', function() {
            const rejectButtons = document.querySelectorAll('button[value="reject"]');
            rejectButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to reject this booking?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>