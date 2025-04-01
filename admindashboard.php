<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/newestlogo.jpg">
    <title>Casafix Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary:rgb(248, 232, 58);
            --primary-light: rgb(248, 232, 58);;
            --secondary: #0f172a;
            --light: #f8fafc;
            --gray: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        
        body {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: black;
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgb(248, 232, 58);;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            color: var(--primary-light);
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
        }
        
        .menu-item.active {
            border-left: 4px solid var(--primary-light);
        }
        
        .menu-item i {
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
            color:rgb(248, 232, 58);;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            display: none;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            transition: all 0.3s ease;
            overflow-x: hidden;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .mobile-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--secondary);
            display: none;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .user-name {
            font-weight: 600;
        }
        
        /* Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            display: flex;
            flex-direction: column;
        }
        
        .card-title {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .stat-icon {
            font-size: 1.5rem;
            align-self: flex-end;
            margin-top: auto;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .stat-icon.blue {
            background-color: var(--primary-light);
        }
        
        .stat-icon.green {
            background-color: var(--success);
        }
        
        .stat-icon.orange {
            background-color: var(--warning);
        }
        
        .stat-icon.red {
            background-color: var(--danger);
        }
        
        /* Tables */
        .content-section {
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .recent-services {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px 20px;
            text-align: left;
        }
        
        th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #64748b;
        }
        
        tr {
            border-bottom: 1px solid var(--gray);
        }
        
        tr:last-child {
            border-bottom: none;
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status.completed {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .status.pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status.cancelled {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #64748b;
            transition: color 0.3s;
        }
        
        .action-btn:hover {
            color: var(--primary);
        }
        
        /* Recent Activity */
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        
        .activity-details h4 {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .activity-time {
            font-size: 0.75rem;
            color: #64748b;
        }
        a{
            text-decoration:none;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                position: fixed;
                height: 100%;
            }
            
            .sidebar-header {
                justify-content: center;
                padding: 15px;
            }
            
            .logo span, .menu-item span {
                display: none;
            }
            
            .menu-item {
                justify-content: center;
                padding: 15px;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: none;
            }
            
            .sidebar.active {
                display: block;
            }
            
            .sidebar-header {
                justify-content: space-between;
                padding: 15px 20px;
            }
            
            .logo span, .menu-item span {
                display: inline;
            }
            
            .menu-item {
                justify-content: flex-start;
                padding: 12px 20px;
            }
            
            .toggle-sidebar {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block;
            }
            
            th, td {
                padding: 10px 15px;
            }
            
            .hide-sm {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .user-info {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="assets/newestlogo.jpg" width="50px" height="70px" style="border-radius:50%;">
                    <span>CaSaFix</span>
                </div>
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </div>
               <a href="updategallery.php">
               <div class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Update Gallery</span>
                </div>
               </a>
                <div class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Payments</span>
                </div>
                <a href="posttoshop.php">
                <div class="menu-item">
                    <i class="fas fa-user-friends"></i>
                    <span>Update shop</span>
                </div></a>
                <div class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div>
                    <button class="mobile-toggle" id="mobileToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Dashboard</h1>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div class="user-name">Admin User</div>
                        <small>Administrator</small>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-container">
                <a href="Total_users.php"  rel="noopener noreferrer">
                <div class="card stat-card">
                    <div class="card-title"><b>TOTAL Users</b></div>
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div></a>
                
                <a href="Total_companies.php"  rel="noopener noreferrer">
                <div class="card stat-card">
                    <div class="card-title"><b>TOTAL Companies</b></div>
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div></a>  

                <a href="Activecompanies.php"  rel="noopener noreferrer">
                <div class="card stat-card">
                    <div class="card-title"><b>Active Companies</b></div>
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>                              
                </div></a>  
                
               <a href="viewbookings.php">
               <div class="card stat-card">
                    <div class="card-title"><b>View Bookings</b></div>
                    <div class="stat-icon red">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
               </a>
            </div>
            
            
            
        </div>
    </div>
    
    <script>
        // Toggle sidebar on mobile
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Close sidebar when clicking the close button
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.getElementById('mobileToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                event.target !== mobileToggle && 
                !mobileToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>