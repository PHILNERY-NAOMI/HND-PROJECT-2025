<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: provider_login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'Account';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch filter parameters
$filterOption = $_GET['filterOption'] ?? 'all';
$searchInput = $_GET['searchInput'] ?? '';

// Build SQL query based on filter
$sql = "SELECT * FROM user_bookings WHERE 1=1";

if ($filterOption === 'company') {
    $sql .= " AND company_name LIKE :search";
} elseif ($filterOption === 'service') {
    $sql .= " AND service_name LIKE :search";
} elseif ($filterOption === 'recent') {
    $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

if ($filterOption === 'company' || $filterOption === 'service') {
    $stmt->bindValue(':search', "%$searchInput%");
}

$stmt->execute();
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            padding-top: 2rem;
            padding-bottom: 4rem;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, rgb(238, 253, 28) 0%, rgb(238, 253, 28) 100%);
            padding: 1.5rem;
            color: black;
            border: none;
        }
        
        h1 {
            font-weight: 600;
            margin: 0;
            font-size: 1.8rem;
            letter-spacing: 0.5px;
        }
        
        .search-form {
            background-color: #ffffff;
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            border: 1px solid #d9e2ef;
            box-shadow: none;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4a6bdc;
            box-shadow: 0 0 0 3px rgba(74, 107, 220, 0.15);
        }
        
        .btn-primary {
            background-color: black;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: rgb(238, 253, 28);
            color:black;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(74, 107, 220, 0.3);
        }
        
        .table-container {
            background-color: #ffffff;
            border-radius: 0 0 10px 10px;
            padding: 1rem;
        }
        
        .table {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9ff;
        }
        
        .table thead th {
            background-color: #f0f4f8;
            color: #4a5568;
            font-weight: 600;
            border-top: none;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem 0.75rem;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        
        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-color: #edf2f7;
        }
        
        .table-badge {
            padding: 0.35rem 0.65rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-payment {
            background-color: rgb(242, 243, 234);
            color: #3182ce;
        }
        
        .badge-hours {
            background-color: rgb(245, 246, 236);
            color: #319795;
        }
        
        .badge-total {
            background-color: rgb(246, 247, 242);
            color: #e53e3e;
            font-weight: 600;
        }
        
        .message-cell {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .date-cell {
            white-space: nowrap;
        }
        
        .count-badge {
            background-color: #4a6bdc;
            color: white;
            border-radius: 30px;
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            margin-left: 10px;
        }
        
        @media (max-width: 768px) {
            .search-form .row > div {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-calendar-check me-2"></i>Bookings</h1>
                <small class="text-white-50">Manage all your service bookings in one place</small>
            </div>
            <span class="count-badge"><?= count($bookings) ?> Total</span>
        </div>

        <!-- Search Bar and Filter Options -->
        <div class="search-form">
            <form method="GET" action="viewbookings.php" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="searchInput" class="form-control" placeholder="Search by company or service..." value="<?= htmlspecialchars($searchInput) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="filterOption" class="form-select">
                        <option value="all" <?= $filterOption === 'all' ? 'selected' : '' ?>>All Bookings</option>
                        <option value="company" <?= $filterOption === 'company' ? 'selected' : '' ?>>By Company</option>
                        <option value="service" <?= $filterOption === 'service' ? 'selected' : '' ?>>By Service</option>
                        <option value="recent" <?= $filterOption === 'recent' ? 'selected' : '' ?>>Recent Bookings</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter Results
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Company</th>
                            <th>Service</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Hours</th>
                            <th>Payment</th>
                            <th>Total (FRS)</th>
                            <th>Date & Time</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="bookingsTableBody">
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="12" class="text-center py-5">
                                    <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="mb-0 mt-2">No bookings found matching your criteria</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><span class="fw-bold"><?= htmlspecialchars($booking['id']) ?></span></td>
                                    <td><?= htmlspecialchars($booking['your_name']) ?></td>
                                    <td class="fw-medium"><?= htmlspecialchars($booking['company_name']) ?></td>
                                    <td><?= htmlspecialchars($booking['service_name']) ?></td>
                                    <td class="small"><?= htmlspecialchars($booking['address']) ?></td>
                                    <td><?= htmlspecialchars($booking['telephone']) ?></td>
                                    <td><span class="table-badge badge-hours"><?= htmlspecialchars($booking['estimated_hours']) ?></span></td>
                                    <td><span class="table-badge badge-payment"><?= htmlspecialchars($booking['payment_method']) ?></span></td>
                                    <td><span class="table-badge badge-total"><?= htmlspecialchars($booking['total_amount']) ?></span></td>
                                    <td class="date-cell">
                                        <div class="fw-medium"><?= htmlspecialchars($booking['preferred_date']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($booking['preferred_time']) ?></small>
                                    </td>
                                    <td class="message-cell" title="<?= htmlspecialchars($booking['message']) ?>"><?= htmlspecialchars($booking['message']) ?></td>
                                    <td class="small text-muted"><?= htmlspecialchars(date('M d, Y', strtotime($booking['created_at']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function filterBookings() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const filterOption = document.getElementById('filterOption').value;
        const rows = document.querySelectorAll('#bookingsTableBody tr');

        rows.forEach(row => {
            const company = row.cells[2].textContent.toLowerCase(); // Updated index for company
            const service = row.cells[3].textContent.toLowerCase(); // Updated index for service
            const created = row.cells[11].textContent; // Updated index for created_at

            let match = false;

            switch (filterOption) {
                case 'company':
                    match = company.includes(searchInput);
                    break;
                case 'service':
                    match = service.includes(searchInput);
                    break;
                case 'recent':
                    const currentDate = new Date();
                    const createdDate = new Date(created);
                    const diffTime = Math.abs(currentDate - createdDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    match = diffDays <= 7; // Show bookings from the last 7 days
                    break;
                default:
                    match = company.includes(searchInput) || service.includes(searchInput);
                    break;
            }

            row.style.display = match ? '' : 'none';
        });
    }
</script>
</body>
</html>