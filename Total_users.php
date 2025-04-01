<?php
require_once('config/db.php');
$query = "SELECT * FROM users";
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
    <title>Total Users</title>
    <style>
        :root {
            --primary-color: rgb(244, 240, 26);
            --primary-dark: #FFC107;
            --secondary-color: #6c757d;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --info-color: #17a2b8;
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 2rem;
        }

        .page-header {
            background:while;
            color: var(--dark-color);
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .main-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            border: none;
        }

        .card-header {
            background: white;
            border-bottom: 3px solid var(--primary-color);
            padding: 1.5rem;
        }

        .card-body {
            padding: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: var(--primary-color);
            color: var(--dark-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            padding: 15px 10px;
            border: none;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            padding: 12px 10px;
            border-color: #f0f0f0;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f0f0f0;
        }

        .btn {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border: none;
            transition: all 0.3s;
        }

        .btn-edit {
            background-color: var(--info-color);
            color: white;
        }

        .btn-edit:hover {
            background-color: #138496;
            box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
            transform: translateY(-2px);
        }

        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
            transform: translateY(-2px);
        }

        .password-cell {
            font-family: monospace;
            letter-spacing: 1px;
        }

        .user-count {
            background-color: var(--primary-color);
            color: var(--dark-color);
            border-radius: 20px;
            padding: 0.3rem 1rem;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin: 0 3px;
        }

        .action-btn i {
            font-size: 1rem;
        }

        @media (max-width: 992px) {
            .table-responsive {
                border-radius: 10px;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container text-center">
            <h1 class="header-title">System Users Directory</h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card main-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            User Directory
                            <?php 
                            $count = mysqli_num_rows($result);
                            echo "<span class='user-count'>$count</span>";
                            ?>
                        </h2>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-id-badge mr-2"></i>ID</th>
                                        <th><i class="fas fa-user mr-2"></i>First Name</th>
                                        <th><i class="fas fa-user mr-2"></i>Last Name</th>
                                        <th><i class="fas fa-map-marker-alt mr-2"></i>Address</th>
                                        <th><i class="fas fa-phone mr-2"></i>Phone Number</th>
                                        <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                        <th><i class="fas fa-lock mr-2"></i>Password</th>
                                        <th colspan="2" class="text-center"><i class="fas fa-cogs mr-2"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['first_name']; ?></td>
                                                <td><?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['phone_number']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td class="password-cell">
                                                    <?php echo str_repeat("•", 8); ?>
                                                    <i class="fas fa-eye-slash text-secondary ml-2" title="Show password"></i>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-delete action-btn" title="Delete User">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="fas fa-exclamation-circle text-secondary mr-2"></i>
                                                No users found in the database
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