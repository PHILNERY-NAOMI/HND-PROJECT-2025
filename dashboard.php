<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$company_name = $_SESSION['company_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaSaFix | Company Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="assets/newestlogo.jpg">
    <style>
        :root {
            --primary-color: #000;
            --secondary-color: rgb(251, 254, 81);;
            --accent-color: #000;
            --light-bg: #f4f6f9;
            --text-color: #000;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }
        
        * {
            transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), #000);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .sidebar-logo h2 {
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
            color: white;
        }
        
        .nav-pills .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .nav-pills .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 20px;
            background-color: var(--light-bg);
        }
        
        .welcome-section {
            background: linear-gradient(to right, var(--secondary-color), var(--accent-color));
            color: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }
        
        .dashboard-card {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        
        .stats-card-icon {
            color: var(--secondary-color);
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .stats-card h2 {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .quick-actions .btn {
            background-color: var(--light-bg);
            color: var(--text-color);
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .quick-actions .btn:hover {
            background-color: white;
            transform: translateX(5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        footer {
            background-color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="assets/newestlogo.jpg" alt="Company Logo">
            <h2>CaSa<span style="color: rgb(238, 253, 28);;">Fix</span></h2>
        </div>
        <ul class="nav nav-pills flex-column mt-4">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user me-2"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-alt me-2"></i> Reports
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog me-2"></i> Providers
                </a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <span class="avatar me-2"><?php echo strtoupper(substr($company_name, 0, 1)); ?></span>
                                <?php echo htmlspecialchars($company_name); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-item ms-3">
                            <a class="nav-link position-relative" href="#">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="welcome-section">
            <h1 class="mb-2">WELCOME, <?php echo htmlspecialchars($company_name); ?>!</h1>
            <p class="opacity-75">Dashboard Overview | <?php echo date("F j, Y"); ?></p>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="fillyourinfo.php" class="text-decoration-none">
                            <div class="card dashboard-card">
                                <div class="card-body stats-card">
                                    <div class="stats-card-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title text-muted">Become Active</h5>
                                        <h2>Active</h2>
                                        <small class="text-muted"><i class="fas fa-chart-line me-1"></i> 0% from last month</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <a href="View_companies.php" class="text-decoration-none">
                            <div class="card dashboard-card">
                                <div class="card-body stats-card">
                                    <div class="stats-card-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title text-muted">Active Companies</h5>
                                        <h2>Active</h2>
                                        <small class="text-muted"><i class="fas fa-chart-line me-1"></i> 0% from last month</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <a href="company_bookings.php" class="text-decoration-none">
                            <div class="card dashboard-card">
                                <div class="card-body stats-card">
                                    <div class="stats-card-icon">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title text-muted">Pending Tasks</h5>
                                        <h2>0</h2>
                                        <small class="text-muted"><i class="fas fa-calendar-day me-1"></i> 0 due today</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card dashboard-card quick-actions">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn w-100">
                            <span><i class="fas fa-book me-2"></i> Work Report</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn w-100">
                            <span><i class="fas fa-exclamation-circle me-2"></i> Complaint Report</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn w-100">
                            <span><i class="fas fa-history me-2"></i> Service History</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn w-100">
                            <span><i class="fas fa-headset me-2"></i> Support</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <p class="text-muted mb-0">&copy; 2025 CaSaFix Company Portal. All rights reserved.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>