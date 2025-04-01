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
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all companies
$stmt = $conn->query("SELECT * FROM active_companies");
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Companies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="assets/newestlogo.jpg">
    <style>
        :root {
            --primary-color: rgb(249, 247, 114);
            --primary-hover: #e6af00;
            --shadow-color: rgba(252, 255, 79, 0.5);
            --hover-shadow: rgba(239, 243, 9, 0.6);
            --border-color: #ddd;
            --text-primary: #333;
            --text-secondary: #555;
            --separator-color: rgb(198, 200, 106);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        a{
            text-decoration:none;
        }
        
        .page-header {
            background-color: var(--primary-color);
            color: var(--text-primary);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 12px var(--shadow-color);
        }
        
        /* Custom styles for the cards */
        .card {
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            border-radius: 15px;
            box-shadow: 0 4px 8px var(--shadow-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 650px;
            overflow: hidden;
            background-color: white;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px var(--hover-shadow);
        }
        
        .logo-container {
            padding: 20px 0;
            display: flex;
            justify-content: center;
        }
        
        .company-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-img-container {
            height: 300px;
            overflow: hidden;
        }
        
        .card-img-top {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 12px;
            color: var(--text-primary);
            text-align: center;
        }
        
        .card-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }
        
        .category-separator {
            border-top: 2px solid var(--separator-color);
            margin: 30px 0 20px;
        }
        
        .category-heading {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: var(--text-primary);
            padding-left: 10px;
            border-left: 5px solid var(--primary-color);
        }
        
        .btn-book {
            width: 150px;
            padding: 10px;
            border: none;
            background-color: var(--primary-color);
            border-radius: 25px;
            color: var(--text-primary);
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: block;
            margin: 15px auto 0;
        }
        
        .btn-book:hover {
            background-color: var(--primary-hover);
            transform: scale(1.05);
        }
        
        .property-label {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .info-item {
            display: flex;
            align-items: baseline;
            margin-bottom: 8px;
        }
        
        .info-icon {
            margin-right: 8px;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1 class="text-center"><b>ACTIVE COMPANIES</b></h1>
        </div>
    </div>
    
    <div class="container">
        <?php
        $categories = [];
        foreach ($companies as $company) {
            $services = explode(', ', $company['services']);
            foreach ($services as $service) {
                // Normalize the service name (trim and convert to lowercase)
                $normalizedService = strtolower(trim($service));
                
                // Use the normalized service name as the key
                if (!isset($categories[$normalizedService])) {
                    $categories[$normalizedService] = [
                        'display_name' => $service, // Keep the original display name
                        'companies' => []
                    ];
                }
                $categories[$normalizedService]['companies'][] = $company;
            }
        }

        foreach ($categories as $service => $data) {
            $displayName = $data['display_name'];
            $companies_in_category = $data['companies'];
            
            echo "<h2 class='category-heading'>$displayName</h2>";
            echo "<div class='category-separator'></div>";
            echo "<div class='row'>";
            
            foreach ($companies_in_category as $company) {
                // Assuming the company logo is in a field called 'logo', 
                // If not present, use work_photo as fallback
                $logoImage = isset($company['logo']) ? $company['logo'] : $company['work_photo'];
                
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <div class='logo-container'>
                            <img src='{$logoImage}' class='company-logo' alt='{$company['company_name']} Logo'>
                        </div>
                        <div class='card-img-container'>
                            <img src='{$company['work_photo']}' class='card-img-top' alt='Company Work Sample'>
                        </div>
                        <div class='card-body'>
                            <h5 class='card-title'>{$company['company_name']}</h5>
                            <div class='info-item'>
                                <span class='info-icon'><i class='fas fa-tools'></i></span>
                                <span class='property-label'>Services:</span> 
                                <span class='ms-1'>{$company['services']}</span>
                            </div>
                            <div class='info-item'>
                                <span class='info-icon'><i class='fas fa-map-marker-alt'></i></span>
                                <span class='property-label'>Location:</span> 
                                <span class='ms-1'>{$company['location']}</span>
                            </div>
                            <a href='services.php?company_name={$company['company_name']}'>
                                <button class='btn-book'><i class='fas fa-calendar-check me-2'></i>Book</button>
                            </a>
                        </div>
                    </div>
                </div>";
            }
            echo "</div>"; // Close the row
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>