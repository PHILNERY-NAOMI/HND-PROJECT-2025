<?php
// Include the database connection file
require 'Bookingscript.php';

// Fetch all bookings from the database
$stmt = $conn->query("SELECT bookings.*, Active_workers.name AS provider_name FROM bookings JOIN Active_workers ON bookings.provider_id = Active_workers.id ORDER BY booking_date DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the user is logged in (replace with your session logic)
session_start();
$loggedInUser = $_SESSION['username'] ?? null; // Replace 'username' with your session key
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .table {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #4361ee;
            color: white;
            font-weight: bold;
        }
        .table tbody tr:hover {
            background-color: #f1f3f5;
        }
        .btn-accept, .btn-decline {
            margin: 2px;
        }
        .btn-accept:disabled, .btn-decline:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Bookings</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Provider Name</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Booking Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['provider_name']; ?></td>
                        <td><?php echo $booking['customer_name']; ?></td>
                        <td><?php echo $booking['customer_email']; ?></td>
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td><?php echo $booking['notes']; ?></td>
                        <td>
                            <button class="btn btn-success btn-accept" 
                                    onclick="handleAction('accept', <?php echo $booking['id']; ?>, '<?php echo $booking['provider_name']; ?>')">
                                Accept
                            </button>
                            <button class="btn btn-danger btn-decline" 
                                    onclick="handleAction('decline', <?php echo $booking['id']; ?>, '<?php echo $booking['provider_name']; ?>')">
                                Decline
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Function to handle accept/decline actions
        function handleAction(action, bookingId, providerName) {
            const loggedInUser = "<?php echo $loggedInUser; ?>"; // Get the logged-in user from PHP

            // Check if the logged-in user matches the provider name
            if (loggedInUser !== providerName) {
                alert("Error: This provider is currently logged out.");
                return;
            }

            // Disable the opposite button
            const buttons = event.target.parentElement.querySelectorAll('button');
            buttons.forEach(button => {
                if (button !== event.target) {
                    button.disabled = true;
                }
            });

            // Send the action to the server
            fetch('handle_booking_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    bookingId: bookingId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Booking ${action}ed successfully!`);
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>