<?php
require_once('config/db2.php');
$query = "SELECT * FROM company_registration";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/newestlogo.jpg">
    <link rel="stylesheet" href="Bootstrap file/bootstrap 4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Total Companies</title>
    <style>
        :root {
            --primary-color: rgb(238, 240, 113);
            --primary-hover: rgb(238, 253, 28);
            --accent-color: #FFF6CC;
            --text-dark: #2D2D2D;
            --text-light: #6C6C6C;
            --bg-light: #F8F9FA;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        /* Navbar Styling */
        .company-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header Styling */
        .page-header {
            background-color: white;
            padding: 30px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
        }

        .header-title {
            font-weight: 700;
            color: var(--text-dark);
            position: relative;
            display: inline-block;
            margin-bottom: 0;
        }

        .header-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            transform: translateX(-50%);
        }

        /* Card Styling */
        .companies-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            margin-bottom: 40px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 20px 30px;
        }

        .card-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .card-body {
            padding: 0;
        }

        /* Table Styling */
        .companies-table {
            margin: 0;
        }

        .companies-table th {
            background: linear-gradient(to right, var(--primary-color), var(--primary-hover));
            color: var(--text-dark);
            font-weight: 600;
            text-transform: uppercase;
            padding: 16px 15px;
            border: none;
            font-size: 0.85rem;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .companies-table td {
            padding: 16px 15px;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.05);
            font-size: 0.95rem;
        }

        .companies-table tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .companies-table tr:hover {
            background-color: var(--accent-color);
            transition: background-color 0.3s ease;
        }

        /* Company ID Cell */
        .company-id {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Company Name Cell */
        .company-name {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Password Cell */
        .password-cell {
            font-family: monospace;
            letter-spacing: 1px;
        }

        /* Location Info */
        .location-info {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .location-icon {
            color: #6c757d;
            margin-right: 5px;
        }

        /* Stats Counter */
        .stats-counter {
            display: flex;
            justify-content: space-between;
            background-color: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .counter-item {
            text-align: center;
            padding: 0 15px;
        }

        .counter-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .counter-label {
            font-size: 0.85rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .companies-card {
                width: 100%;
                margin-left: 0;
            }
            
            .table-responsive {
                border-radius: 0 0 12px 12px;
                overflow: hidden;
            }
        }
    </style>
</head>
<body>
    <br>
    <div class="page-header">
        <div class="container text-center">
            <h1 class="header-title">REGISTERED COMPANIES DIRECTORY</h1>
        </div>
    </div>

    <div class="container">
        <!-- Stats Counter -->
        <div class="stats-counter">
            <div class="counter-item">
                <div class="counter-value">
                    <?php echo mysqli_num_rows($result); ?>
                </div>
                <div class="counter-label">Total Companies</div>
            </div>
            <div class="counter-item">
                <div class="counter-value">
                    <?php 
                    $uniqueCountries = [];
                    mysqli_data_seek($result, 0);
                    while($row = mysqli_fetch_assoc($result)) {
                        if(!in_array($row['country'], $uniqueCountries)) {
                            $uniqueCountries[] = $row['country'];
                        }
                    }
                    echo count($uniqueCountries);
                    mysqli_data_seek($result, 0);
                    ?>
                </div>
                <div class="counter-label">Countries</div>
            </div>
            <div class="counter-item">
                <div class="counter-value">
                    <?php 
                    $uniqueTowns = [];
                    mysqli_data_seek($result, 0);
                    while($row = mysqli_fetch_assoc($result)) {
                        if(!in_array($row['town'], $uniqueTowns)) {
                            $uniqueTowns[] = $row['town'];
                        }
                    }
                    echo count($uniqueTowns);
                    mysqli_data_seek($result, 0);
                    ?>
                </div>
                <div class="counter-label">Towns</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card companies-card">
                    <div class="card-header">
                        <h2 class="text-center">Total Registered Companies</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table companies-table text-center">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-building mr-2"></i>Company ID</th>
                                        <th><i class="fas fa-briefcase mr-2"></i>Company Name</th>
                                        <th><i class="fas fa-user-tie mr-2"></i>Manager Name</th>
                                        <th><i class="fas fa-city mr-2"></i>Town</th>
                                        <th><i class="fas fa-globe-americas mr-2"></i>Country</th>
                                        <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                        <th><i class="fas fa-key mr-2"></i>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td class="company-id"><?php echo $row['id']; ?></td>
                                            <td class="company-name"><?php echo $row['company_name']; ?></td>
                                            <td><?php echo $row['manager_name']; ?></td>
                                            <td>
                                                <span class="location-info">
                                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                                    <?php echo $row['town']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $row['country']; ?></td>
                                            <td>
                                                <a href="mailto:<?php echo $row['email']; ?>" class="text-decoration-none">
                                                    <?php echo $row['email']; ?>
                                                </a>
                                            </td>
                                            <td class="password-cell"><?php echo str_repeat("•", 8); ?></td>
                                        </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-exclamation-circle text-warning mr-2"></i>
                                                No registered companies found
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="Bootstrap file/bootstrap 4/js/bootstrap.min.js"></script>
</body>
</html>