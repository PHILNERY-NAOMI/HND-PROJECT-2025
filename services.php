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

// Fetch the company name from the query parameter
$company_name = $_GET['company_name'] ?? '';

// Fetch the company details
$stmt = $conn->prepare("SELECT * FROM active_companies WHERE company_name = :company_name");
$stmt->execute(['company_name' => $company_name]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$company) {
    die("Company not found.");
}

// Fetch the services offered by the company
$services = explode(', ', $company['services']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - <?php echo htmlspecialchars($company_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .service-category {
            margin-bottom: 20px;
        }
        .service-category h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .service-category hr {
            border-top: 2px solid #ccc;
            margin: 10px 0;
        }
        .service-link {
            text-decoration: none;
            color: inherit;
        }
        .service-link:hover {
            text-decoration: none;
            color:rgb(134, 136, 43);;
        }
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        form{
            width:400px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($company_name); ?></h1>
        <?php
        foreach ($services as $service) {
            $service_trimmed = trim($service);
            echo "<div class='service-category'>";
            echo "<a href='#' class='service-link' onclick='openBookingForm(\"" . htmlspecialchars($company_name) . "\", \"" . htmlspecialchars($service_trimmed) . "\")'>";
            echo "<h3>" . htmlspecialchars($service_trimmed) . "</h3>";
            echo "</a>";
            echo "<hr>";
            echo "</div>";
        }
        ?>
    </div>

  <!-- Popup Form -->
<div class="overlay" id="overlay"></div>
<div class="popup-form" id="bookingForm" style="max-height: 80vh; overflow-y: auto;">
    <h2>Book Service</h2>
    <form id="bookingFormContent" action="bookings.php" method="POST" onsubmit="submitForm(event)">
 
       <div class="mb-3">
            <label for="yourName" class="form-label">Your Name:</label>
            <input type="text" id="yourName" name="yourName" class="form-control" required>
        </div>    

        <div class="mb-3">
            <label for="companyName" class="form-label">Company Name:</label>
            <input type="text" id="companyName" name="companyName" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="serviceName" class="form-label">Service Name:</label>
            <input type="text" id="serviceName" name="serviceName" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input type="text" id="address" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Telephone Number:</label>
            <input type="tel" id="telephone" name="telephone" class="form-control" required>
        </div>
       
        <div class="mb-3">
            <label for="paymentMethod" class="form-label">Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod" class="form-control" required>
                <option value="MTN Mobile Money">MTN Mobile Money</option>
                <option value="Orange Money">Orange Money</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="preferredDate" class="form-label">Preferred Date:</label>
            <input type="date" id="preferredDate" name="preferredDate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="preferredTime" class="form-label">Preferred Time:</label>
            <input type="time" id="preferredTime" name="preferredTime" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message:</label>
            <textarea id="message" name="message" class="form-control" rows="3" placeholder="Please detaily explain what you want us to do here"></textarea>
        </div>
        <div class="mb-3">
            <label for="estimatedHours" class="form-label">Estimated Work Hours:</label>
            <input type="number" id="estimatedHours" name="estimatedHours" class="form-control" min="1" required oninput="calculateTotalAmount()">
        </div>
        <div class="mb-3">
            <label for="totalAmount" class="form-label">Total Amount to be Paid (XAF):</label>
            <input type="text" id="totalAmount" name="totalAmount" class="form-control" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Book</button>
        <button type="button" class="btn btn-secondary" onclick="closeBookingForm()">Close</button>
    </form>
</div>

<script>
    // Function to handle form submission via AJAX
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        const formData = new FormData(document.getElementById('bookingFormContent'));

        // Send form data to bookings.php using AJAX
        fetch('bookings.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Booking successful!'); // Show success message
            closeBookingForm(); // Close the form
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.'); // Show error message
        });
    }

    // Function to calculate the total amount
    function calculateTotalAmount() {
        const estimatedHours = document.getElementById('estimatedHours').value;
        const ratePerHour = 3500; // Rate per hour in FRS
        const totalAmount = estimatedHours * ratePerHour;
        document.getElementById('totalAmount').value = totalAmount.toLocaleString(); 
    }

    // Function to open the booking form
    function openBookingForm(companyName, serviceName) {
        document.getElementById('companyName').value = companyName;
        document.getElementById('serviceName').value = serviceName;
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('bookingForm').style.display = 'block';
    }

    // Function to close the booking form
    function closeBookingForm() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('bookingForm').style.display = 'none';
    }
</script>
</body>
</html>