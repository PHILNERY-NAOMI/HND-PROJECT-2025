<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: provider_login.php");
    exit();
}

$company_name = isset($_SESSION['company_name']) ? $_SESSION['company_name'] : '';


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['Location'];
    $services = implode(', ', $_POST['service_category']);
    $work_photo = '';

    // Handle file upload
    if (isset($_FILES['work_photo']) && $_FILES['work_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $work_photo = $upload_dir . basename($_FILES['work_photo']['name']);
        move_uploaded_file($_FILES['work_photo']['tmp_name'], $work_photo);
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO active_companies (company_name, location, services, work_photo) VALUES (:company_name, :location, :services, :work_photo)");
    $stmt->execute([
        ':company_name' => $company_name,
        ':location' => $location,
        ':services' => $services,
        ':work_photo' => $work_photo
    ]);

    header("Location: Allproviders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .popup-form {
            display: block; /* Ensure the form is visible */
            position: relative;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 500px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .custom-service-input {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .custom-service-input input {
            flex-grow: 1;
        }
        .custom-service-input button {
            flex-shrink: 0;
        }
        #customServicesList {
            margin-top: 10px;
        }
        .custom-service-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="popup-form">
            <h2>Add Your Details</h2>
            <form id="providerForm" action="Activeproviderscript.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Company Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($company_name); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="Location" class="form-label">Location:</label>
                    <input type="text" id="Location" name="Location" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="provider name" class="form-label">Provider Name:</label>
                    <input type="text" id="provider name" name="provider name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Service Categories:</label>
                    <div class="service-checkboxes">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Plumbing" id="plumbing">
                            <label class="form-check-label" for="plumbing">Plumbing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Cooking" id="cooking">
                            <label class="form-check-label" for="cooking">Cooking</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Cleaning" id="cleaning">
                            <label class="form-check-label" for="cleaning">Cleaning</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Roofing" id="roofing">
                            <label class="form-check-label" for="roofing">Roofing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Flooring" id="flooring">
                            <label class="form-check-label" for="flooring">Flooring</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Gardening" id="gardening">
                            <label class="form-check-label" for="gardening">Gardening</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_category[]" value="Electrical Maintenance" id="electrical">
                            <label class="form-check-label" for="electrical">Electrical Maintenance</label>
                        </div>
                        <!-- Custom services added by the user will appear here -->
                        <div id="customServicesList"></div>
                    </div>
                    <!-- Add Custom Service -->
                    <div class="custom-service-input">
                        <input type="text" id="customServiceInput" placeholder="Add another service" class="form-control">
                        <button type="button" id="addCustomService" class="btn btn-primary btn-sm">Add</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="work_photo" class="form-label">Upload Work Photo:</label>
                    <input type="file" id="work_photo" name="work_photo" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript to handle adding custom services
        document.getElementById('addCustomService').addEventListener('click', function() {
            const customServiceInput = document.getElementById('customServiceInput');
            const customServiceValue = customServiceInput.value.trim();
            
            if (customServiceValue) {
                const customServicesList = document.getElementById('customServicesList');
                const newServiceId = 'custom_' + Date.now();
                
                // Create a new checkbox for the custom service
                const serviceDiv = document.createElement('div');
                serviceDiv.className = 'form-check custom-service-item';
                serviceDiv.innerHTML = `
                    <input class="form-check-input" type="checkbox" name="service_category[]" value="${customServiceValue}" id="${newServiceId}" checked>
                    <label class="form-check-label" for="${newServiceId}">${customServiceValue}</label>
                `;
                
                customServicesList.appendChild(serviceDiv);
                customServiceInput.value = '';
            }
        });
    </script>
</body>
</html>