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
$stmt = $conn->query("SELECT * FROM active_providers");
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Providers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the cards */
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgb(252, 255, 79);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 600px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgb(239, 243, 9);
        }
        .card-img-top {
            height: 450px; /* Fixed height for images */
            object-fit: cover; /* Ensure images cover the area */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-text {
            font-size: 0.9rem;
            color: #555;
        }
        .category-separator {
            border-top: 2px solid rgb(198, 200, 106);
            margin: 20px 0;
        }
        .category-heading {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        button{
            width:150px;
            padding:10px;
            border:none;
            background-color:yellow;
            border-radius:25px;
            color:black;
        }
        
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4"><b>ACTIVE PROVIDERS</b></h1>
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
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='{$company['work_photo']}' class='card-img-top' alt='Company Image'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$company['company_name']}</h5>
                            <p class='card-text'><strong>Services:</strong> {$company['services']}</p>
                            <p class='card-text'><strong>Location:</strong> {$company['location']}</p>
                            <a href='services.php?company_name={$company['company_name']}'><button><b>Book</b></button></a>
                        </div>
                    </div>
                </div>";
            }
            echo "</div>"; // Close the row
        }
        ?>
    </div>
</body>
</html>