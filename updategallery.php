<?php
// Start session to check if admin is logged in (You may need to adjust this based on your authentication system)
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'galleryscript.php';
    
    // Get form data
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $activity = mysqli_real_escape_string($conn, $_POST['activity']);
    
    // Image upload handling
    $target_dir = "uploads/gallery/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . time() . '_' . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $upload_success = false;
    
    // Check if image file is actual image
    if(isset($_FILES["image"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            // Upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $upload_success = true;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error_message = "File is not an image.";
        }
    } else {
        $error_message = "Please select an image to upload.";
    }
    
    // If upload successful, insert into database
    if ($upload_success) {
        $sql = "INSERT INTO gallery (company_name, date, time, activity, image_path) 
                VALUES ('$company_name', '$date', '$time', '$activity', '$target_file')";
        
        if (mysqli_query($conn, $sql)) {
            $success_message = "Gallery item added successfully!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Gallery - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f6f9;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--secondary-color);
        }
        
        .header h1 {
            margin-bottom: 0.5rem;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }
        
        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        textarea {
            height: 120px;
            resize: vertical;
        }
        
        .file-input-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            cursor: pointer;
        }
        
        .file-input-button {
            border: 2px dashed #ccc;
            padding: 1rem;
            text-align: center;
            border-radius: 4px;
            background: #f9f9f9;
            color: #666;
            transition: all 0.3s;
            cursor: pointer;
            width: 100%;
        }
        
        .file-input-button:hover {
            border-color: var(--primary-color);
            background: #f0f8ff;
        }
        
        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .selected-file {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: var(--dark-color);
        }
        
        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            display: block;
            width: 100%;
            font-weight: 600;
        }
        
        .btn:hover {
            background: #2980b9;
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .nav-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .nav-link:hover {
            text-decoration: underline;
        }
        
        .icon {
            margin-right: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 0 0.8rem;
            }
            
            .card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Update Gallery</h1>
            <p>Add new items to your gallery showcase</p>
        </div>
        
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle icon"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle icon"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" id="company_name" name="company_name" required>
                </div>
                
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" id="time" name="time" required>
                </div>
                
                <div class="form-group">
                    <label for="activity">Activity</label>
                    <textarea id="activity" name="activity" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <div class="file-input-container">
                        <div class="file-input-button" id="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i> Choose an image
                        </div>
                        <input type="file" id="image" name="image" class="file-input" accept="image/*" required>
                    </div>
                    <div class="selected-file" id="file-name">No file selected</div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-plus-circle icon"></i> Post to Gallery
                </button>
            </form>
        </div>
        
        <a href="gallery.php" class="nav-link">
            <i class="fas fa-images icon"></i> View Gallery
        </a>
    </div>
    
    <script>
        // Display selected filename
        document.getElementById('image').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file selected';
            document.getElementById('file-name').textContent = fileName;
            
            if (this.files[0]) {
                document.getElementById('file-input-label').style.borderColor = '#3498db';
                document.getElementById('file-input-label').innerHTML = '<i class="fas fa-check-circle"></i> Image Selected';
            } else {
                document.getElementById('file-input-label').style.borderColor = '#ccc';
                document.getElementById('file-input-label').innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Choose an image';
            }
        });
    </script>
</body>
</html>