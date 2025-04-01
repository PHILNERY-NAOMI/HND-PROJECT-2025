<?php
// Include database connection
include 'galleryscript.php';

// Query to get all gallery items, ordered by newest first
$sql = "SELECT * FROM gallery ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Close connection after fetching the data
// mysqli_close($conn); -- We'll close it after using the data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - CaSaFix</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="assets/newestlogo.jpg">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --accent-color: #e67e22;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .header h1 {
            color: var(--secondary-color);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .header::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            margin: 1.5rem auto;
            border-radius: 2px;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 2rem;
        }
        
        .gallery-item {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .gallery-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 3px solid var(--primary-color);
        }
        
        .gallery-content {
            padding: 1.5rem;
        }
        
        .gallery-company {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }
        
        .gallery-meta {
            display: flex;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #777;
        }
        
        .gallery-date, .gallery-time {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }
        
        .gallery-date i, .gallery-time i {
            margin-right: 0.4rem;
            color: var(--primary-color);
        }
        
        .gallery-activity {
            line-height: 1.6;
            color: #555;
            margin-bottom: 1rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        
        .gallery-btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }
        
        .gallery-btn:hover {
            background-color: #2980b9;
        }
        
        .empty-gallery {
            text-align: center;
            grid-column: 1 / -1;
            padding: 3rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .empty-gallery i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
        
        .empty-gallery h3 {
            color: #666;
            margin-bottom: 1rem;
        }
        
     
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                grid-gap: 1.5rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 1.5rem 1rem;
            }
            
            .header {
                margin-bottom: 2rem;
            }
        }
        
        /* Modal styles for full image view */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }
        
        .modal-content {
            display: block;
            position: relative;
            margin: auto;
            max-width: 80%;
            max-height: 80vh;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        
        .modal-close:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Our Project Gallery</h1>
            <p>Explore our collection of home repair and improvement projects</p>
        </div>
        
        <div class="gallery-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="gallery-item">
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['company_name']); ?> project" class="gallery-img" onclick="openModal(this.src)">
                        <div class="gallery-content">
                            <h3 class="gallery-company"><?php echo htmlspecialchars($row['company_name']); ?></h3>
                            <div class="gallery-meta">
                                <div class="gallery-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo htmlspecialchars($row['date']); ?>
                                </div>
                                <div class="gallery-time">
                                    <i class="far fa-clock"></i>
                                    <?php echo htmlspecialchars($row['time']); ?>
                                </div>
                            </div>
                            <p class="gallery-activity"><?php echo htmlspecialchars($row['activity']); ?></p>
                            <a href="#" class="gallery-btn" onclick="openModal('<?php echo htmlspecialchars($row['image_path']); ?>')">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-gallery">
                    <i class="far fa-images"></i>
                    <h3>No gallery items yet</h3>
                    <p>Be the first to add projects to our gallery showcase!</p>
                </div>
            <?php endif; ?>
        </div>
        
        
    </div>
    
    <!-- Modal for full image view -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
    </div>
    
    <script>
        // Modal functionality
        function openModal(src) {
            document.getElementById('modalImg').src = src;
            document.getElementById('imageModal').style.display = 'block';
            event.preventDefault();
        }
        
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        
        // Close modal when clicking outside the image
        window.onclick = function(event) {
            var modal = document.getElementById('imageModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>