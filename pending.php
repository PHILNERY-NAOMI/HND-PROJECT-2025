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

// Fetch the company's name from the session
$company_name = $_SESSION['company_name'] ?? '';

// Fetch filter parameters
$filterOption = $_GET['filterOption'] ?? 'all';
$searchInput = $_GET['searchInput'] ?? '';

// Build SQL query based on filter
$sql = "SELECT * FROM bookings WHERE company_name = :company_name"; // Filter by the company's name

if ($filterOption === 'service') {
    $sql .= " AND service_name LIKE :search";
} elseif ($filterOption === 'recent') {
    $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

// Bind the company's name to the query
$stmt->bindValue(':company_name', $company_name);

if ($filterOption === 'service') {
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
    <title>Pending Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/newestlogo.jpg">
    <style>
        :root {
            --primary-color: rgb(238, 253, 28);
            --primary-dark: rgb(238, 253, 28);
            --primary-light: rgb(238, 253, 28);
            --primary-very-light: #FFF8E1;
            --text-dark: #5D4037;
            --success-color: #4CAF50;
            --danger-color: #F44336;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }
        
        .container {
            max-width: 1200px;
            padding: 0 20px;
        }
        
        .page-header {
            background: #ffff;
            color: var(--text-dark);
            padding: 30px 0;
            border-radius: 0 0 15px 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .page-header h1 {
            margin: 0;
            font-weight: 600;
            font-size: 2.2rem;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            border: none;
            overflow: hidden;
        }
        
        .form-control, .form-select, .btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 213, 79, 0.25);
            border-color: var(--primary-color);
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s ease;
            color: var(--text-dark);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 213, 79, 0.3);
            color: var(--text-dark);
        }
        
        .table {
            border-radius: 12px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead {
            background: var(--primary-color);
        }
        
        .table thead th {
            color: var(--text-dark);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 15px 10px;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: var(--primary-very-light);
        }
        
        .table td {
            padding: 15px 10px;
            font-size: 0.9rem;
            vertical-align: middle;
        }
        
        .search-card {
            margin-bottom: 25px;
            padding: 20px;
            background: white;
        }
        
        .search-icon {
            color: var(--primary-dark);
            margin-right: 8px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 0;
            color: #6c757d;
        }
        
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .btn-accept {
            background-color: var(--success-color);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-accept:hover {
            background-color: #388E3C;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(76, 175, 80, 0.3);
        }
        
        .btn-reject {
            background-color: var(--danger-color);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-reject:hover {
            background-color: #D32F2F;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(244, 67, 54, 0.3);
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-calendar-check me-3"></i>Pending Bookings</h1>
                <div>
                    <?php if(!empty($company_name)): ?>
                        <span class="fw-light">Company:</span> <span class="fw-bold"><?= htmlspecialchars($company_name) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card search-card">
            <form method="GET" action="pending.php" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search search-icon"></i></span>
                        <input type="text" name="searchInput" class="form-control" placeholder="Search by service..." value="<?= htmlspecialchars($searchInput) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="filterOption" class="form-select">
                        <option value="all" <?= $filterOption == 'all' ? 'selected' : '' ?>>All Bookings</option>
                        <option value="service" <?= $filterOption == 'service' ? 'selected' : '' ?>>By Service</option>
                        <option value="recent" <?= $filterOption == 'recent' ? 'selected' : '' ?>>Recent Bookings</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i> ID</th>
                        <th><i class="fas fa-user me-1"></i> Name</th>
                        <th><i class="fas fa-concierge-bell me-1"></i> Service</th>
                        <th><i class="fas fa-map-marker-alt me-1"></i> Address</th>
                        <th><i class="fas fa-phone me-1"></i> Phone</th>
                        <th><i class="fas fa-clock me-1"></i> Hours</th>
                        <th><i class="fas fa-credit-card me-1"></i> Payment</th>
                        <th><i class="fas fa-money-bill-wave me-1"></i> Total (FRS)</th>
                        <th><i class="fas fa-calendar me-1"></i> Date</th>
                        <th><i class="fas fa-hourglass me-1"></i> Time</th>
                        <th><i class="fas fa-comment me-1"></i> Message</th>
                        <th><i class="fas fa-history me-1"></i> Created</th>
                        <th><i class="fas fa-tasks me-1"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="bookingsTableBody">
                    <?php if (count($bookings) > 0): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['id']) ?></td>
                                <td><?= htmlspecialchars($booking['your_name']) ?></td>
                                <td><?= htmlspecialchars($booking['service_name']) ?></td>
                                <td><?= htmlspecialchars($booking['address']) ?></td>
                                <td><?= htmlspecialchars($booking['telephone']) ?></td>
                                <td><?= htmlspecialchars($booking['estimated_hours']) ?></td>
                                <td>
                                    <span class="status-badge" style="background-color: var(--primary-light); color: var(--text-dark);">
                                        <?= htmlspecialchars($booking['payment_method']) ?>
                                    </span>
                                </td>
                                <td><strong><?= htmlspecialchars($booking['total_amount']) ?></strong></td>
                                <td><?= htmlspecialchars($booking['preferred_date']) ?></td>
                                <td><?= htmlspecialchars($booking['preferred_time']) ?></td>
                                <td>
                                    <?php if (!empty($booking['message'])): ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($booking['message']) ?>">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">No message</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $date = new DateTime($booking['created_at']);
                                        echo $date->format('M d, Y');
                                    ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-accept" 
                                                onclick="handleBooking(<?= $booking['id'] ?>, 'accept')" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Accept Booking">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-reject" 
                                                onclick="handleBooking(<?= $booking['id'] ?>, 'reject')" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Reject Booking">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="13" class="empty-state">
                                <i class="fas fa-calendar-times fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h5>No bookings found</h5>
                                <p class="text-muted">Try adjusting your search or filter criteria</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmationModalBody">
                    Are you sure you want to proceed with this action?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function filterBookings() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const filterOption = document.getElementById('filterOption').value;
            const rows = document.querySelectorAll('#bookingsTableBody tr');

            rows.forEach(row => {
                const service = row.cells[2].textContent.toLowerCase();
                const created = row.cells[11].textContent;

                let match = false;

                switch (filterOption) {
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
                        match = service.includes(searchInput);
                        break;
                }

                row.style.display = match ? '' : 'none';
            });
        }
        
        // Handle booking acceptance or rejection
        function handleBooking(bookingId, action) {
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    const confirmBtn = document.getElementById('confirmActionBtn');
    const modalBody = document.getElementById('confirmationModalBody');
    
    // Set modal content based on action
    if (action === 'accept') {
        modalBody.innerHTML = `Are you sure you want to <strong>accept</strong> booking #${bookingId}?`;
        confirmBtn.className = 'btn btn-accept';
        confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>Accept';
    } else {
        modalBody.innerHTML = `Are you sure you want to <strong>reject</strong> booking #${bookingId}?`;
        confirmBtn.className = 'btn btn-reject';
        confirmBtn.innerHTML = '<i class="fas fa-times me-2"></i>Reject';
    }
    
    // Set up the confirmation button action
    confirmBtn.onclick = function() {
        // Send an AJAX request to update the booking status
        fetch('update_booking_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                bookingId: bookingId,
                action: action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to reflect the updated status
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing your request.');
        });
        
        // Hide the modal
        modal.hide();
    };
    
    // Show the modal
    modal.show();
}
    </script>
</body>
</html>