<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap file/bootstrap 4/css/bootstrap.min.css">
    <link rel="icon" href="assets/newestlogo.jpg">
    <title>CaSaFix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Circular', -apple-system, BlinkMacSystemFont, Roboto, 'Helvetica Neue', sans-serif;
        }

        body {
            color: #222;
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Header */
        header {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: rgb(238, 253, 28);
            font-size: 24px;
            font-weight: bold;
        }

        .search-bar {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 40px;
            padding: 8px 16px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.2s ease;
        }

        .search-bar:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.18);
        }

        .search-bar input {
            border: none;
            outline: none;
            padding: 8px;
            width: 300px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-menu button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .user-menu button:hover {
            background-color: #f7f7f7;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #ddd;
            border-radius: 21px;
            padding: 5px 5px 5px 12px;
            cursor: pointer;
        }

        .profile-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #717171;
        }

        /* Hero Section with Slideshow */
        .hero {
            position: relative;
            height: 70vh;
            overflow: hidden;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 10;
            width: 80%;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 16px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 20px;
            margin-bottom: 24px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            color:black;
        }

        .cta-button {
            background-color: rgb(238, 253, 28);
            color: black;
            border: none;
            padding: 14px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .cta-button:hover {
            background-color: rgb(238, 253, 28);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:url('assets/back3.jpg');
            background-size:cover;
        }

        /* Categories Section */
        .categories {
            padding: 40px 0;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .category-list {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            overflow-x: auto;
            padding-bottom: 16px;
            scrollbar-width: none;
        }

        .category-list::-webkit-scrollbar {
            display: none;
        }

        .category-item {
            text-align: center;
            min-width: 80px;
        }

        .category-icon {
            width: 24px;
            height: 24px;
            margin: 0 auto 8px;
        }

        .category-name {
            font-size: 14px;
        }

        /* Featured Cards Section */
        .featured-cards {
            padding: 40px 0;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .card-content {
            padding: 16px;
        }

        .card-title {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .card-desc {
            color: #717171;
            margin-bottom: 8px;
        }

        .card-price {
            font-weight: bold;
        }

        /* Image Slider Section */
        .image-slider-section {
            padding: 40px 0;
        }

        .slider-container {
            position: relative;
            margin: 0 -24px;
        }

        .slider {
            display: flex;
            overflow-x: hidden;
            scroll-behavior: smooth;
            padding: 20px 24px;
        }

        .slider-item {
            min-width: 300px;
            height: 300px;
            margin-right: 16px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .slider-item:last-child {
            margin-right: 0;
        }

        .slider-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .slider-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 16px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            color: white;
        }

        .slider-arrows {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            z-index: 10;
            padding: 0 12px;
        }

        .arrow {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .arrow:hover {
            transform: scale(1.1);
        }

        .arrow span {
            font-size: 20px;
            font-weight: bold;
        }

        /* Footer */
        footer {
            background-color: #000;
            padding: 40px 0;
            margin-top: 40px;
            border-top: 1px solid #ddd;
            
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
           
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin-bottom: 24px;
            color:#ffff;
        }

        .footer-column h3 {
            margin-bottom: 16px;
            font-size: 16px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 8px;
            
        }

        .footer-column a {
            color: #222;
            text-decoration: none;
            color:#ffff;
        }

        .footer-column a:hover {
            text-decoration: underline;
        }

        .copyright {
            border-top: 1px solid #ddd;
            padding-top: 24px;
            margin-top: 24px;
            text-align: center;
            color: #717171;
        }
        /* different website links */
         .navigate{
            display:flex;
            padding:10px;
            margin-left:310px;
            list-style:none;
            
         }
         .navigate li{
            padding:25px;
         }
         .navigate a{
            text-decoration:none;
            color:black;
         }
         .navigate a:hover{
            color:rgb(211, 215, 151);
         }
         .gallery{
            padding:15px;
            border:none;
            border-radius:20px;
            width:150px;
            background-color:yellow;
         }
         .gallery:hover{
                cursor: pointer;
                color:red;
         }
         
         /* Added dropdown styles */
         .dropdown {
            position: relative;
            display: inline-block;
         }
         
         .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 8px;
         }
         
         .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
         }
         
         .dropdown-content a:hover {
            background-color: #f1f1f1;
            color: rgb(211, 215, 151);
         }
         
         .dropdown:hover .dropdown-content {
            display: block;
         }
         
         /* Login modal */
         .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
         }
         
         .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 12px;
         }
         
         .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
         }
         
         .close:hover,
         .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
         }
         
         .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
         }
         
         .modal-button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
         }
         
         .login-button {
            background-color: rgb(238, 253, 28);
            color: black;
         }
         
         .cancel-button {
            background-color: #ccc;
         }

    </style>
</head>
<body>
    <!-- Header -->
    <header style="background-color:rgb(162, 162, 162); opacity:40%;">
        <div class="container">
            <nav>
                <div class="logo">
                <img src="assets/newestlogo.jpg" width="50px" style="border-radius:50%;">
                    <h1 style="margin-left:55px; margin-top:-70px;"><span style="color:black;"><b>CaSa</b></span><span><b>Fix</b></span></h1>
                </div>
            </nav>
        </div>
    </header>
    

    <!-- Hero Section with Slideshow -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Find your perfect home repair</h1>
            <p>Discover new and unique companies all over Cameroon</p>
            <button class="cta-button" id="exploreBtn">Explore Now</button>
        </div>
    </section>

   

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <ul class="navigate">
                <a href="#"><li>Home</li></a>
                <a href="about.php"><li>About</li></a>
                <a href="#"><li>Contact Us</li></a>
                <li class="dropdown">
                    <a href="#">Login</a>
                    <div class="dropdown-content">
                        <a href="user_login.php">As User</a>
                        <a href="login.php">As Company</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#">Signup</a>
                    <div class="dropdown-content">
                        <a href="userregform.php">As User</a>
                        <a href="companyregistration.php">As Company</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <!-- Featured Cards Section -->
    <section class="featured-cards">
        <div class="container">
            <h2 class="section-title">Some Featured Companies</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-image" style="background-image: url('Active companies/com2.jpg');"></div>
                    <div class="card-content">
                        <div class="card-title">Handy Man Home Services</div>
                        <div class="card-desc">Plumbing, flooring, roofing ...</div>
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-image" style="background-image: url('Active companies/com12.jpg');"></div>
                    <div class="card-content">
                        <div class="card-title">Finish Coat Painting LTD</div>
                        <div class="card-desc">specialised painting services</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image" style="background-image: url('Active companies/com13.jpg');"></div>
                    <div class="card-content">
                        <div class="card-title">Building Cleaning</div>
                        <div class="card-desc">Cleaning Services</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Gallery display Section -->
    <section class="image-slider-section">
        <div class="container">
            <h2 class="section-title">View our achievements!</h2>
            <div class="slider-container">
                <div class="slider" id="imageSlider">
                    <div class="slider-item">
                        <img src="assets/trans1.jpg" alt="Experience 1" class="slider-image">
                        <div class="slider-content">
                            <h3>Fixed Palor Corridor floor</h3>
                            <p>By Handy Man services</p>
                        </div>
                    </div>
                    <div class="slider-item">
                        <img src="assets/roofing.jpg" alt="Experience 2" class="slider-image">
                        <div class="slider-content">
                            <h3>Roofing and Flooring</h3>
                            <p>By Handy Man services</p>
                        </div>
                    </div>
                    <div class="slider-item">
                        <img src="assets/new.jpg" alt="Experience 3" class="slider-image">
                        <div class="slider-content">
                            <h3>Kitchen Built from scratch</h3>
                            <p>By STAINLER Services</p>
                        </div>
                    </div>
                    <div class="slider-item">
                        <img src="assets/paint.jpg" alt="Experience 4" class="slider-image">
                        <div class="slider-content">
                            <h3>Freshly Painted wall</h3>
                            <p>By Finish coat painting ltd</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <br>
        <center><a href="gallery.php"><button class="gallery" id="viewGalleryBtn">View Gallery</button></a></center>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login Required</h2>
            <p>You need to login before you can explore our services.</p>
            <div class="modal-buttons">
                <button class="modal-button cancel-button" id="cancelLogin">Cancel</button>
                <a href="popup.php"><button class="modal-button login-button" id="proceedLogin">Login</button></a>
            </div>
        </div>
    </div>

    <!-- Footer -->
   
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Services</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Get a Quote</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">How It Works</a></li>
                    <li><a href="#">Become a Pro</a></li>
                    <li><a href="#">Customer Reviews</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul>
                    <li><a href="#">Email: support@casafix.com</a></li>
                    <li><a href="#">Phone: +237 123 456 789</a></li>
                    <li><a href="#">Address: 123 CasaFix St, Yaoundé, Cameroon</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="#"><img src="assets/facebook-icon.png" alt="Facebook" style="width: 20px; vertical-align: middle;"> Facebook</a></li>
                    <li><a href="#"><img src="assets/twitter-icon.png" alt="Twitter" style="width: 20px; vertical-align: middle;"> Twitter</a></li>
                    <li><a href="#"><img src="assets/instagram-icon.png" alt="Instagram" style="width: 20px; vertical-align: middle;"> Instagram</a></li>
                    <li><a href="#"><img src="assets/linkedin-icon.png" alt="LinkedIn" style="width: 20px; vertical-align: middle;"> LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 CaSaFix, Inc. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    // JavaScript to handle the gallery button
    document.getElementById('viewGalleryBtn').addEventListener('click', function() {
        window.location.href = 'gallery.html';
    });
    
    // Get the modal
    var modal = document.getElementById("loginModal");
    
    // Get the button that opens the modal
    var btn = document.getElementById("exploreBtn");
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // Get modal buttons
    var cancelBtn = document.getElementById("cancelLogin");
    var proceedBtn = document.getElementById("proceedLogin");
    
    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks on Cancel, close the modal
    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks on Login, redirect to login page
    proceedBtn.onclick = function() {
        window.location.href = "login_user.php";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>