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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-bottom: 50px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #2c3e50;
            font-weight: 600;
            margin: 30px 0;
            text-align: center;
            font-size: 2.2rem;
            position: relative;
            padding-bottom: 15px;
        }
        h1:after {
            content: "";
            position: absolute;
            width: 100px;
            height: 4px;
            background-color: rgb(238, 253, 28);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 30px;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: rgb(238, 253, 28);
            color: black;
            font-weight: 500;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(236, 240, 241, 0.5);
        }
        .table tbody tr:hover {
            background-color: rgba(236, 240, 241, 0.8);
        }
        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #ecf0f1;
            font-size: 0.95rem;
        }
        .company-name {
            font-weight: 600;
            color: #2c3e50;
        }
        .location-cell {
            position: relative;
            padding-left: 25px !important;
        }
        .location-cell:before {
            content: "\f3c5";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 15px;
            color: #e74c3c;
            font-size: 0.85rem;
        }
        .services-cell {
            max-width: 250px;
        }
        .services-badge {
            display: inline-block;
            background-color: rgb(255, 255, 250);
            color: #4a5568;
            border-radius: 30px;
            padding: 5px 10px;
            margin: 2px;
            font-size: 0.8rem;
        }
        .img-thumbnail {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            border: none;
            box-shadow: 0 2px 5px transparent;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .img-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .id-badge {
            background-color: rgb(238, 253, 28);
            color: black;
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-building me-2"></i>Active Companies</h1>
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Location</th>
                        <th>Services</th>
                        <th>Work Photo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($companies as $company): ?>
                        <tr>
                            <td><span class="id-badge"><?php echo $company['id']; ?></span></td>
                            <td class="company-name"><?php echo $company['company_name']; ?></td>
                            <td class="location-cell"><?php echo $company['location']; ?></td>
                            <td class="services-cell">
                                <?php
                                    $services = explode(',', $company['services']);
                                    foreach ($services as $service) {
                                        echo '<span class="services-badge">'.trim($service).'</span> ';
                                    }
                                ?>
                            </td>
                            <td><img src="<?php echo $company['work_photo']; ?>" class="img-thumbnail" alt="Work Photo"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>