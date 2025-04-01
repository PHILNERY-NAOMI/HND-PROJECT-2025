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

// Fetch filter parameters
$filterOption = $_GET['filterOption'] ?? 'all';
$searchInput = $_GET['searchInput'] ?? '';

// Build SQL query to fetch only current user's bookings
$sql = "SELECT * FROM user_bookings WHERE user_id = :user_id";

if ($filterOption === 'company') {
    $sql .= " AND company_name LIKE :search";
} elseif ($filterOption === 'service') {
    $sql .= " AND service_name LIKE :search";
} elseif ($filterOption === 'recent') {
    $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id']);

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
        <title>your Bookings</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" href="assets/newestlogo.jpg">
        <style>
            :root {
                --primary-color: rgb(245, 253, 28);
                --secondary-color: #1cc88a;
                --accent-color: #f6c23e;
                --dark-color: #5a5c69;
                --light-color: #f8f9fc;
            }
            
            body {
                background-color: var(--light-color);
                font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                color: #444;
            }
            
            .container {
                max-width: 1200px;
                padding: 1.5rem;
            }
            
            .page-header {
                background: linear-gradient(135deg, var(--primary-color), #000);
                color: white;
                padding: 2rem 0;
                border-radius: 0.5rem;
                margin-bottom: 2rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            .card {
                border: none;
                border-radius: 0.5rem;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                margin-bottom: 1.5rem;
                overflow: hidden;
            }
            
            .card-header {
                background-color: white;
                border-bottom: 1px solid #e3e6f0;
                padding: 1rem 1.25rem;
                font-weight: 700;
                color: var(--dark-color);
            }
            
            .search-area {
                background-color: white;
                padding: 1.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                margin-bottom: 1.5rem;
            }
            
            .btn-primary {
                background-color: var(--primary-color);
                color:black;
                border-color: var(--primary-color);
                padding: 0.5rem 1rem;
                font-weight: 600;
            }
            
            .btn-primary:hover {
                background-color: rgb(245, 253, 28);
                color:#000;
                border-color: #000;
            }
            
            .table {
                margin-bottom: 0;
            }
            
            .table thead th {
                background-color: var(--primary-color);
                color: black;
                border-color: #000;
                vertical-align: middle;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .table tbody tr:hover {
                background-color: rgba(78, 115, 223, 0.05);
            }
            
            .table td {
                font-size: 0.9rem;
                padding: 0.75rem;
                vertical-align: middle;
            }
            
            .badge {
                font-size: 0.75rem;
                font-weight: 600;
                padding: 0.5em 0.75em;
                border-radius: 0.25rem;
            }
            
            .btn-cancel {
                background-color: #e74a3b;
                border-color: #e74a3b;
                color: white;
                transition: all 0.2s;
            }
            
            .btn-cancel:hover {
                background-color: #d52a1a;
                border-color: #c9271a;
                color: black;
            }
            
            .form-control, .form-select {
                padding: 0.5rem 1rem;
                border: 1px solid #d1d3e2;
                border-radius: 0.35rem;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: #bac8f3;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            }
            
            .empty-state {
                text-align: center;
                padding: 3rem 0;
                color: #b7b9cc;
            }
            
            .empty-state i {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            
            /* Make table responsive */
            @media (max-width: 992px) {
                .table-responsive {
                    max-height: 600px;
                }
                
                .table thead {
                    position: sticky;
                    top: 0;
                    z-index: 10;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Page Header -->
            <div class="page-header text-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-calendar-check me-2"></i>My Bookings</h1>
                <p class="text-white-50 mt-2">View and manage all your service bookings</p>
            </div>
            
            <!-- Search & Filter Card -->
            <div class="card search-area">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-search me-2"></i>Search & Filter</span>
                    <a href="userbooking.php" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-redo-alt me-1"></i>Reset
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" action="userbooking.php" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-search text-primary"></i>
                                </span>
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
                                <i class="fas fa-filter me-2"></i>Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Bookings Table Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list-alt me-2"></i>Booking Details</span>
                    <span class="badge bg-primary"><?= count($bookings) ?> Bookings</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Company</th>
                                    <th>Service</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Hours</th>
                                    <th>Payment</th>
                                    <th>Total (FRS)</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="bookingsTableBody">
                                <?php if (count($bookings) > 0): ?>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($booking['id']) ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($booking['company_name']) ?></div>
                                            </td>
                                            <td><?= htmlspecialchars($booking['service_name']) ?></td>
                                            <td class="text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($booking['address']) ?>">
                                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                <?= htmlspecialchars($booking['address']) ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                <?= htmlspecialchars($booking['telephone']) ?>
                                            </td>
                                            <td class="text-center"><?= htmlspecialchars($booking['estimated_hours']) ?></td>
                                            <td>
                                                <?php 
                                                $paymentMethod = htmlspecialchars($booking['payment_method']);
                                                $paymentIcon = 'fa-credit-card';
                                                $paymentClass = 'text-primary';
                                                
                                                if (stripos($paymentMethod, 'cash') !== false) {
                                                    $paymentIcon = 'fa-money-bill';
                                                    $paymentClass = 'text-success';
                                                } elseif (stripos($paymentMethod, 'transfer') !== false) {
                                                    $paymentIcon = 'fa-exchange-alt';
                                                    $paymentClass = 'text-info';
                                                }
                                                ?>
                                                <i class="fas <?= $paymentIcon ?> <?= $paymentClass ?> me-1"></i>
                                                <?= $paymentMethod ?>
                                            </td>
                                            <td class="text-end fw-bold"><?= htmlspecialchars($booking['total_amount']) ?></td>
                                            <td>
                                                <i class="far fa-calendar text-muted me-1"></i>
                                                <?= htmlspecialchars($booking['preferred_date']) ?>
                                            </td>
                                            <td>
                                                <i class="far fa-clock text-muted me-1"></i>
                                                <?= htmlspecialchars($booking['preferred_time']) ?>
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($booking['message']) ?>">
                                                <?= htmlspecialchars($booking['message']) ?: '<span class="text-muted fst-italic">No message</span>' ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $createdDate = new DateTime($booking['created_at']);
                                                $currentDate = new DateTime();
                                                $diff = $createdDate->diff($currentDate);
                                                
                                                $timeAgo = "";
                                                if ($diff->d < 1) {
                                                    $timeAgo = "Today";
                                                } elseif ($diff->d == 1) {
                                                    $timeAgo = "Yesterday";
                                                } elseif ($diff->d < 7) {
                                                    $timeAgo = $diff->d . " days ago";
                                                } else {
                                                    $timeAgo = $createdDate->format('M d, Y');
                                                }
                                                ?>
                                                <span data-bs-toggle="tooltip" title="<?= htmlspecialchars($booking['created_at']) ?>">
                                                    <?= $timeAgo ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-cancel btn-sm" onclick="cancelBooking(<?= $booking['id'] ?>)">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="far fa-calendar-times mb-3"></i>
                                                <h4>No Bookings Found</h4>
                                                <p class="text-muted">You don't have any bookings matching your search criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Booking Details -->
        <div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Booking Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="bookingDetailsContent">
                        <!-- Details will be filled dynamically -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            
            function filterBookings() {
                const searchInput = document.getElementById('searchInput').value.toLowerCase();
                const filterOption = document.getElementById('filterOption').value;
                const rows = document.querySelectorAll('#bookingsTableBody tr');

                rows.forEach(row => {
                    const company = row.cells[1].textContent.toLowerCase();
                    const service = row.cells[2].textContent.toLowerCase();
                    const created = row.cells[11].textContent;

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

            // Function to handle booking cancellation
            function cancelBooking(bookingId) {
                if (confirm("Are you sure you want to cancel this booking?")) {
                    fetch(`cancel_booking.php?booking_id=${bookingId}`, {
                        method: 'GET',
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Create a Bootstrap toast notification
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                        toastContainer.style.zIndex = '11';
                        
                        toastContainer.innerHTML = `
                            <div class="toast align-items-center text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <i class="fas fa-check-circle me-2"></i> ${data}
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        `;
                        
                        document.body.appendChild(toastContainer);
                        const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
                        toast.show();
                        
                        // Reload the page after a short delay
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("An error occurred while canceling the booking.");
                    });
                }
            }
        </script>
    </body>
    </html>