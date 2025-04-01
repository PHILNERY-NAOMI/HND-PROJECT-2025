<?php
// Include the database connection
require 'Allprovidersscript.php';

// Fetch all providers from the database
$stmt = $conn->query("SELECT * FROM Active_workers ORDER BY service_category, name");
$providers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group providers by service category
$groupedProviders = [];
foreach ($providers as $provider) {
    $category = $provider['service_category'];
    if (!isset($groupedProviders[$category])) {
        $groupedProviders[$category] = [];
    }
    $groupedProviders[$category][] = $provider;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Providers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .category-heading {
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .horizontal-line {
            border-top: 2px solid #ccc;
            margin: 30px 0;
        }
        .table {
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-5">Active Service Providers</h1>

        <?php foreach ($groupedProviders as $category => $providersInCategory): ?>
            <div class="category-heading"><?php echo ucfirst($category); ?></div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Service Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($providersInCategory as $provider): ?>
                        <tr>
                            <td><img src="<?php echo $provider['work_photo']; ?>" alt="Work Photo"></td>
                            <td><?php echo $provider['name']; ?></td>
                            <td><?php echo $provider['age']; ?></td>
                            <td><?php echo $provider['gender']; ?></td>
                            <td><?php echo $provider['service_category']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="horizontal-line"></div>
        <?php endforeach; ?>
    </div>
</body>
</html>