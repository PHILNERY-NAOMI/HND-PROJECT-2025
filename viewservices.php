<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'home_services');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all services from the database
$result = $conn->query("SELECT * FROM services ORDER BY timestamp DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: rgb(252, 255, 79);
            --primary-dark: rgb(230, 232, 60);
            --accent-color: #3498db;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .page-header:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }
        
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
            margin: 0 auto;
            max-width: 1400px;
        }
        
        .card {
            flex: 1 1 calc(33.333% - 25px);
            min-width: 280px;
            border-radius: 16px;
            padding: 25px;
            background-color: white;
            box-shadow: var(--card-shadow);
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            overflow: hidden;
            position: relative;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .card-icon {
            display: inline-block;
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            border-radius: 50%;
            text-align: center;
            line-height: 60px;
            margin-bottom: 15px;
        }
        
        .card-icon img {
            vertical-align: middle;
            max-width: 30px;
            max-height: 30px;
        }
        
        .card h2 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
        }
        
        .card p {
            margin: 0 0 20px 0;
            color: #666;
            font-size: 15px;
            line-height: 1.5;
        }
        
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .timestamp {
            font-size: 12px;
            color: #999;
            font-style: italic;
        }
        
        .card select {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 14px;
            transition: border-color var(--transition-speed);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }
        
        .card select:focus {
            outline: none;
            border-color: var(--accent-color);
        }
        
        .book-btn {
            width: 100%;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: #000;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color var(--transition-speed);
            margin-top: 10px;
        }
        
        .book-btn:hover {
            background-color: var(--primary-dark);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(3px);
        }
        
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            width: 95%;
            max-width: 450px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-content h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .modal-content label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }
        
        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color var(--transition-speed);
        }
        
        .modal-content input:focus,
        .modal-content select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .modal-content button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: #000;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color var(--transition-speed);
        }
        
        .modal-content button:hover {
            background-color: var(--primary-dark);
        }
        
        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 26px;
            cursor: pointer;
            color: #777;
            transition: color var(--transition-speed);
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .close-btn:hover {
            color: #333;
            background-color: #f1f1f1;
        }
        
        @media (max-width: 992px) {
            .card {
                flex: 1 1 calc(50% - 25px);
            }
        }
        
        @media (max-width: 768px) {
            .card {
                flex: 1 1 100%;
            }
            
            .page-header {
                margin-bottom: 30px;
            }
            
            .modal-content {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .card {
                padding: 20px;
            }
            
            .card-icon {
                width: 50px;
                height: 50px;
                line-height: 50px;
            }
        }
    </style>
</head>
<body>
    <h1 class="page-header">Available Home Services</h1>
    <div class="card-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-icon">
                        <img src="icons/<?php echo htmlspecialchars($row['icon']); ?>" alt="icon">
                    </div>
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <select>
                        <option selected disabled>Choose a provider</option>
                        <?php foreach (json_decode($row['providers']) as $provider): ?>
                            <option><?php echo htmlspecialchars($provider); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="card-footer">
                        <p class="timestamp">Posted: <?php echo date('M d, Y', strtotime($row['timestamp'])); ?></p>
                    </div>
                    <button class="book-btn" onclick="openBookingModal(<?php echo $row['id']; ?>, <?php echo htmlspecialchars(json_encode($row['providers'])); ?>)">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-services">
                <i class="fas fa-exclamation-circle" style="font-size: 48px; color: #ddd; display: block; text-align: center; margin-bottom: 20px;"></i>
                <p style="text-align: center; font-size: 18px; color: #777;">No services available at the moment. Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeBookingModal()">&times;</span>
            <h2>Schedule Service</h2>
            <form id="bookingForm">
                <label for="name"><i class="fas fa-user"></i> Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required>

                <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

                <label for="service_name"><i class="fas fa-tools"></i> Service Name</label>
                <input type="text" id="service_name" name="service_name" placeholder="Service you're booking" required>
                  
                <label for="provider"><i class="fas fa-user-tie"></i> Select Provider</label>
                <select id="provider" name="provider" required>
                    <!-- Providers will be dynamically populated here -->
                </select>

                <label for="date"><i class="fas fa-calendar-alt"></i> Preferred Date</label>
                <input type="date" id="date" name="date" required>

                <label for="time"><i class="fas fa-clock"></i> Preferred Time</label>
                <input type="time" id="time" name="time" required>

                <button type="submit"><i class="fas fa-check-circle"></i> Confirm Booking</button>
            </form>
        </div>
    </div>

    <script>
        // Function to open the booking modal
        function openBookingModal(serviceId, providers) {
            const modal = document.getElementById('bookingModal');
            const providerSelect = document.getElementById('provider');

            // Clear previous options
            providerSelect.innerHTML = '';
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select a provider';
            defaultOption.selected = true;
            defaultOption.disabled = true;
            providerSelect.appendChild(defaultOption);

            // Populate the provider dropdown
            JSON.parse(providers).forEach(provider => {
                const option = document.createElement('option');
                option.value = provider;
                option.textContent = provider;
                providerSelect.appendChild(option);
            });

            // Set today as the minimum date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').setAttribute('min', today);

            // Display the modal
            modal.style.display = 'flex';
        }

        // Function to close the booking modal
        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            modal.style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('bookingModal');
            if (event.target === modal) {
                closeBookingModal();
            }
        });

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const bookingData = {};
            formData.forEach((value, key) => {
                bookingData[key] = value;
            });

            // Log booking data (you can send this to a server instead)
            console.log('Booking Data:', bookingData);

            // Close the modal
            closeBookingModal();

            // Show a confirmation message with animation
            showConfirmationMessage();
        });
        
        // Function to show confirmation message
        function showConfirmationMessage() {
            // Create confirmation element
            const confirmation = document.createElement('div');
            confirmation.className = 'confirmation-message';
            confirmation.innerHTML = `
                <div class="confirmation-content">
                    <i class="fas fa-check-circle"></i>
                    <h3>Booking Successful!</h3>
                    <p>Your service has been scheduled. A confirmation will be sent to you shortly.</p>
                </div>
            `;
            
            // Add styles
            const style = document.createElement('style');
            style.textContent = `
                .confirmation-message {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background-color: #4CAF50;
                    color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 1000;
                    animation: slideIn 0.5s forwards, fadeOut 0.5s 3.5s forwards;
                    max-width: 350px;
                }
                .confirmation-content {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                }
                .confirmation-content i {
                    font-size: 48px;
                    margin-bottom: 10px;
                }
                .confirmation-content h3 {
                    margin: 5px 0;
                }
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes fadeOut {
                    from {
                        opacity: 1;
                    }
                    to {
                        opacity: 0;
                        display: none;
                    }
                }
            `;
            
            document.head.appendChild(style);
            document.body.appendChild(confirmation);
            
            // Remove after animation completes
            setTimeout(() => {
                confirmation.remove();
            }, 4000);
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>