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

// Sample data - in a real application, you would retrieve this from your database
$pendingServices = 2;
$completedServices = 5;
$upcomingAppointments = [
    ["date" => "2025-03-16", "time" => "10:00 AM", "service" => "Plumbing Repair"],
    ["date" => "2025-03-20", "time" => "2:30 PM", "service" => "Electrical Maintenance"]
];
$recentServices = [
    ["date" => "2025-03-10", "service" => "HVAC Maintenance", "status" => "Completed"],
    ["date" => "2025-03-05", "service" => "Lawn Service", "status" => "Completed"],
    ["date" => "2025-02-28", "service" => "Window Repair", "status" => "Completed"]
];

// Get user info - In a real application, you'd fetch this from your database
$userFirstName = $_SESSION['first_name'] ?? 'User';
$userLastName = $_SESSION['last_name'] ?? '';
$userEmail = $_SESSION['email'] ?? 'user@example.com';
$userProfileImage = $_SESSION['profile_image'] ?? 'default_profile.png';

// Check if profile image exists, if not use default
if (!file_exists($userProfileImage)) {
    $userProfileImage = 'default_profile.png';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard CaSaFix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="assets/newestlogo.jpg">
    <style>
        :root {
            /* Primary Theme Colors - Modify these to change the color scheme */
            --primary-color: rgb(248, 232, 58);
            --secondary-color: #000;
            --accent-color: #f6c23e;
            --dark-color: #000;
            --light-color: #f8f9fc;
            --danger-color: #e74a3b;
            
            /* Card and UI Element Colors */
            --card-bg: white;
            --card-border: rgba(0,0,0,0.05);
            --card-shadow: rgba(0,0,0,0.05);
        }
        
        body {
            background-color: var(--light-color);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding-top: 56px; /* For fixed navbar */
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-color) 70%, #000 100%);
            min-height: calc(100vh - 56px);
            color: white;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link {
            color: black;
            padding: 1rem;
            transition: all 0.2s;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar .sidebar-heading {
            padding: 1rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            font-weight: 800;
        }
        
        .dashboard-card {
            border-radius: 0.5rem;
            border-left: 0.25rem solid var(--primary-color);
            box-shadow: 0 0.15rem 1.75rem 0 var(--card-shadow);
            background-color: var(--card-bg);
            margin-bottom: 1.5rem;
            border: 1px solid var(--card-border);
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
        }
        
        .card-pending {
            border-left-color: var(--accent-color);
        }
        
        .card-completed {
            border-left-color: var(--secondary-color);
        }
        
        .card-appointments {
            border-left-color: var(--primary-color);
        }
        
        .card-icon {
            font-size: 2rem;
        }
        
        .card-icon-pending {
            color: var(--accent-color);
        }
        
        .card-icon-completed {
            color: var(--secondary-color);
        }
        
        .card-icon-appointments {
            color: var(--primary-color);
        }
        
        .top-navbar {
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .service-timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .service-timeline:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 2px;
            background: var(--primary-color);
            opacity: 0.3;
        }
        
        .service-timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .service-timeline-item:before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
        }
        
        .service-timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .badge-completed {
            background-color: var(--secondary-color);
        }
        
        .badge-pending {
            background-color: var(--accent-color);
        }
        
        /* Responsive sidebar adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                min-height: auto;
                padding-bottom: 1rem;
            }
            
            body {
                padding-top: 56px;
            }
            
            .mobile-menu-toggle {
                display: block !important;
            }
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Welcome banner animation */
        .welcome-banner {
            background-image: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner:after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            bottom: -50%;
            left: -50%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 100%);
            transform: rotate(30deg);
            animation: shine 6s infinite;
        }
        
        @keyframes shine {
            0% { transform: rotate(30deg) translateX(-100%); }
            100% { transform: rotate(30deg) translateX(100%); }
        }
        
        /* Profile modal styles */
        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            overflow: auto;
            animation: fadeIn 0.3s;
        }
        
        .profile-modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .profile-close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark-color);
        }
        
        .profile-photo-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--light-color);
            border: 4px solid var(--primary-color);
            position: relative;
            cursor: pointer;
        }
        
        .profile-photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-photo-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 5px;
            color: white;
            font-size: 12px;
            text-align: center;
            transition: all 0.3s;
            opacity: 0;
        }
        
        .profile-photo-container:hover .profile-photo-overlay {
            opacity: 1;
        }
        
        .profile-input {
            display: none;
        }

        /* toggle button */
        /* Dark Mode Styles */
body.dark-mode {
    --light-color: #121212;
    --dark-color: #ffffff;
    --card-bg: #1e1e1e;
    --card-border: rgba(255, 255, 255, 0.1);
    --card-shadow: rgba(255, 255, 255, 0.05);
    background-color: var(--light-color);
    color: var(--dark-color);
}

body.dark-mode .sidebar {
    background: linear-gradient(180deg, #000 0%, #000 70%, rgb(252, 255, 79) 100%);
    color: var(--dark-color);
}

body.dark-mode .sidebar .nav-link {
    color: #fff;
}

body.dark-mode .sidebar .nav-link:hover {
    color: var(--primary-color);
    background-color: rgba(255, 255, 255, 0.1);
}

body.dark-mode .sidebar .nav-link.active {
    color: var(--primary-color);
    background-color: rgba(255, 255, 255, 0.2);
}

body.dark-mode .dashboard-card {
    background-color: var(--card-bg);
    border: 1px solid var(--card-border);
    box-shadow: 0 0.15rem 1.75rem 0 var(--card-shadow);
}

body.dark-mode .top-navbar {
    background-color: var(--card-bg);
    box-shadow: 0 0.15rem 1.75rem 0 rgba(255, 255, 255, 0.15);
}

body.dark-mode .welcome-banner {
    background-image: linear-gradient(135deg, #000 0%, rgb(252, 255, 79)100%);
}

body.dark-mode .profile-modal-content {
    background-color: var(--card-bg);
    color: var(--dark-color);
}

body.dark-mode .profile-close {
    color: var(--dark-color);
}

body.dark-mode .profile-photo-container {
    background-color: var(--light-color);
    border: 4px solid var(--primary-color);
}

body.dark-mode .profile-photo-overlay {
    background-color: rgba(255, 255, 255, 0.6);
    color: var(--dark-color);
}

body.dark-mode .btn-light {
    background-color: var(--card-bg);
    color: var(--dark-color);
    border-color: var(--card-border);
}

body.dark-mode .btn-light:hover {
    background-color: rgb(70, 70, 67);
    color: var(--dark-color);
    
}
.card-body .ale-responsive{
    background-color:#000;
}
body.dark-mode td{
    color:white;
}
body.dark-mode td:hover{
    color:rgb(132, 132, 129)
}
a{
    text-decoration:none;
}
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top top-navbar" style="background-color:black;opacity:40%;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/newestlogo.jpg" width="50px" height="70px" style="border-radius:50%; ">
                <span class="fw-bold text-white">CasaFix</span>
            </a>
            
                <!-- Inside the top navbar, after the user dropdown -->
<div class="d-flex ms-auto align-items-center">
    <!-- Dark Mode Toggle Button -->
    <button id="darkModeToggle" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fas fa-moon"></i> Dark Mode
    </button>
    
    <div class="dropdown">
        <!-- Existing user dropdown code -->
    </div>
</div>
            <button class="navbar-toggler mobile-menu-toggle d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>
              <br><br>
            <div class="d-flex ms-auto align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar me-2">
                            <?php if (file_exists($userProfileImage)): ?>
                                <img src="<?php echo $userProfileImage; ?>" alt="Profile Photo">
                            <?php else: ?>
                                <?php echo substr($userFirstName, 0, 1); ?>
                            <?php endif; ?>
                        </div>
                        <span class="d-none d-sm-inline"><?php echo $userFirstName; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#" id="openProfileModal"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
                         <br><br>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 d-none d-lg-block sidebar collapse" id="sidebarMenu">
                <div class="position-sticky pt-3">
                    <div class="sidebar-heading">
                        Main
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-history me-2"></i>
                                Service History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-star me-2"></i>
                                Reviews
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-heading mt-4">
                        Account
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="openProfileModalSidebar">
                                <i class="fas fa-user-circle me-2"></i>
                                Profile
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="shop.php">
                                <i class="fas fa-credit-card me-2"></i>
                                Shop
                            </a>
                        </li>
                        <li class="nav-item">
                        <i class="fas fa-cog me-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="col-lg-10 ms-sm-auto px-md-4 py-4">
                <!-- Welcome Banner -->
                <div class="welcome-banner p-4 mb-4 text-white fade-in">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold">Welcome back, <?php echo $userFirstName; ?>!</h2>
                            <p class="mb-0">Here's an overview of your home services and upcoming appointments.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Status Cards -->
                <div class="row fade-in">
                <div class="col-xl-4 col-md-6">
    <a href="approved_bookings.php">
        <div class="dashboard-card card-pending p-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="card-icon card-icon-pending">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="small text-muted">Accepted Bookings</div>
                    <div class="h4 mb-0 fw-bold">
                        <?php 
                        try {
                            // Count approved bookings for this user
                            $stmt = $conn->prepare("SELECT COUNT(*) FROM user_bookings WHERE user_id = :user_id AND status = 'Accepted'");
                            $stmt->execute([':user_id' => $_SESSION['user_id']]);
                            echo $stmt->fetchColumn();
                        } catch (PDOException $e) {
                            echo "0"; // Show 0 if there's an error
                            error_log("Database error: " . $e->getMessage());
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
                    
                    <div class="col-xl-4 col-md-6">
                        <div class="dashboard-card card-completed p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="card-icon card-icon-completed">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">Completed Services</div>
                                    <div class="h4 mb-0 fw-bold"><?php echo $completedServices; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="col-xl-4 col-md-6">
    <a href="userbooking.php">  <!-- This already points to the correct page -->
        <div class="dashboard-card card-appointments p-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="card-icon card-icon-appointments">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="small text-muted">View Bookings</div>
                </div>
            </div>
        </div>
    </a>
</div>
                   
                
              
                
                <!-- Quick Actions -->
                <div class="row mt-2 fade-in">
                    <div class="col-12">
                        <div class="dashboard-card">
                            <div class="card-header bg-transparent  py-3">
                                <h6 class="m-0 fw-bold">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3 col-sm-6">
                                        <a href="view_companies.php" class="btn btn-light w-100 p-4 text-center">
                                            <i class="fas fa-tools d-block mb-2 fs-4"></i>
                                            Request Service
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="#" class="btn btn-light w-100 p-4 text-center">
                                            <i class="fas fa-book d-block mb-2 fs-4"></i>
                                            Write report
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="#" class="btn btn-light w-100 p-4 text-center">
                                            <i class="fas fa-file-invoice d-block mb-2 fs-4"></i>
                                            View Invoices
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="#" class="btn btn-light w-100 p-4 text-center">
                                            <i class="fas fa-headset d-block mb-2 fs-4"></i>
                                            Contact Support
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="mt-5 pt-3 pb-4 text-center text-muted">
                    <p>© 2025 HomeServices. All rights reserved.</p>
                </footer>
            </main>
        </div>
    </div>
    
    <!-- Profile Modal -->
    <div id="profileModal" class="profile-modal">
        <div class="profile-modal-content">
            <span class="profile-close">&times;</span>
            <h4 class="text-center mb-4">My Profile</h4>
            
            <form id="profileForm" action="update_profile.php" method="post" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <label for="profilePhoto" class="profile-photo-container">
                        <?php if (file_exists($userProfileImage)): ?>
                            <img src="<?php echo $userProfileImage; ?>" alt="Profile Photo" id="profilePhotoPreview">
                        <?php else: ?>
                            <img src="default_profile.png" alt="Default Profile" id="profilePhotoPreview">
                        <?php endif; ?>
                        <div class="profile-photo-overlay">
                            <i class="fas fa-camera"></i> Change Photo
                        </div>
                    </label>
                    <input type="file" name="profilePhoto" id="profilePhoto" class="profile-input" accept="image/*">
                </div>
                
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $userFirstName; ?>" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $userLastName; ?>" readonly>
                </div>
                
                
                
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Update Profile Photo</button>
                </div>
            </form>
        </div>

        <div class="profile-popup">
    <div class="avatar">
        <img id="profilePhoto" src="default-avatar.png" alt="Profile Photo">
    </div>
    <input type="file" id="profilePhotoInput" accept="image/*" style="display: none;">
    <button onclick="document.getElementById('profilePhotoInput').click()">Update Profile Photo</button>
</div>
    </div>
    
    <!-- Bootstrap and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Modal Functionality
            const profileModal = document.getElementById('profileModal');
            const openProfileBtn = document.getElementById('openProfileModal');
            const openProfileSidebarBtn = document.getElementById('openProfileModalSidebar');
            const closeBtn = document.querySelector('.profile-close');
            const profilePhotoInput = document.getElementById('profilePhoto');
            const profilePhotoPreview = document.getElementById('profilePhotoPreview');
            const profileForm = document.getElementById('profileForm');
            
            // Open modal from top dropdown
            openProfileBtn.addEventListener('click', function() {
                profileModal.style.display = 'block';
            });
            
            // Open modal from sidebar
            if (openProfileSidebarBtn) {
                openProfileSidebarBtn.addEventListener('click', function() {
                    profileModal.style.display = 'block';
                });
            }
            
            // Close modal when clicking X
            closeBtn.addEventListener('click', function() {
                profileModal.style.display = 'none';
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === profileModal) {
                    profileModal.style.display = 'none';
                }
            });
            
            // Handle image preview
            profilePhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePhotoPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    
                    // Submit form when file is selected for immediate upload
                    profileForm.submit();
                }
            });
            
            // Handle form submission via AJAX to prevent page reload
            profileForm.addEventListener('submit', function(e) {
                // Only prevent default if there's actually a file selected
                if (profilePhotoInput.files.length > 0) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch('update_profile.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update all profile images on the page
                            const userAvatars = document.querySelectorAll('.user-avatar img');
                            userAvatars.forEach(avatar => {
                                avatar.src = data.image_path + '?v=' + new Date().getTime(); // Add timestamp to force reload
                            });
                            
                            // Show success message
                            alert('Profile photo updated successfully!');
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating your profile photo.');
                    });
                }
            });
            
            // Active link highlighting
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Add animation class to elements for staggered fade-in effect
            const elementsToAnimate = document.querySelectorAll('.dashboard-card');
            elementsToAnimate.forEach((element, index) => {
                setTimeout(() => {
                    element.classList.add('fade-in');
                }, 100 * index);
            });
        });

        // toggle button
        document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    // Check if dark mode is enabled in localStorage
    const isDarkMode = localStorage.getItem('darkMode') === 'enabled';

    // Apply dark mode if it was previously enabled
    if (isDarkMode) {
        body.classList.add('dark-mode');
        darkModeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
    }

    // Toggle dark mode
    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        const isDarkMode = body.classList.contains('dark-mode');

        // Update button text and save preference in localStorage
        if (isDarkMode) {
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
            localStorage.setItem('darkMode', 'enabled');
        } else {
            darkModeToggle.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
            localStorage.setItem('darkMode', 'disabled');
        }
    });
});
    </script>
</body>
</html>

<?php
// This would normally be in a separate file: update_profile.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profilePhoto"])) {
    session_start();
    
    // Directory where profile images are stored
    $target_dir = "uploads/profiles/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // User-specific filename based on user ID
    $user_id = $_SESSION['user_id'];
    $file_extension = strtolower(pathinfo($_FILES["profilePhoto"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . "user_" . $user_id . "." . $file_extension;
    
    // Valid file extensions
    $valid_extensions = array("jpg", "jpeg", "png", "gif");
    
    $response = array();
    
    // Check if image file is a valid image
    if (in_array($file_extension, $valid_extensions)) {
        if (move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], $target_file)) {
            // Update session to store the path to the profile image
            $_SESSION['profile_image'] = $target_file;
            
            // Return success response
            $response['success'] = true;
            $response['image_path'] = $target_file;
            
            // In a real application, update the user's profile image path in the database
            // Example: updateUserProfileImage($user_id, $target_file);
        } else {
            $response['success'] = false;
            $response['message'] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

