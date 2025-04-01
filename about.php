<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Casafix - Connecting You to Home Repair Professionals</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        header {
            background-color: #2c3e50;
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-text {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-accent {
            color: #e74c3c;
        }

        .menu {
            display: flex;
            list-style: none;
        }

        .menu li {
            margin-left: 30px;
        }

        .menu a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .menu a:hover {
            color: #e74c3c;
        }

        .hero {
            background-color: #34495e;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .content-section {
            padding: 80px 0;
        }

        .two-column {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .image-container {
            flex: 1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .text-content {
            flex: 1;
        }

        h2 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .text-content p {
            margin-bottom: 15px;
        }

        .how-it-works {
            padding: 80px 0;
            background-color:  rgb(249, 250, 242);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background-color:  rgb(238, 253, 28);
            color: black;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
            margin: 0 auto 20px;
        }

        .step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 25px;
            right: -15%;
            width: 30%;
            height: 2px;
            background-color: #e0e0e0;
        }

        .step h3 {
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .values {
            padding: 80px 0;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .value-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s;
        }

        .value-card:hover {
            transform: translateY(-10px);
        }

        .value-icon {
            font-size: 40px;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .value-card h3 {
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .team {
            padding: 80px 0;
            background-color: #f1f5f9;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .team-member {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .team-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .team-member h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .team-member p {
            color: #e74c3c;
            font-weight: 500;
        }

        .testimonials {
            padding: 80px 0;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .testimonial {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            position: relative;
        }

        .testimonial-text::before {
            content: '"';
            font-size: 60px;
            color: #f1f1f1;
            position: absolute;
            left: -20px;
            top: -20px;
            z-index: -1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .author-details h4 {
            margin-bottom: 5px;
        }

        .author-details p {
            color: #666;
            font-size: 0.9rem;
        }

        

      /* footer */
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

        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid #3a546d;
            color: #ccc;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #e74c3c;
            display: block;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #2c3e50;
        }

        @media (max-width: 992px) {
            .two-column {
                flex-direction: column;
            }
            
            .steps {
                flex-direction: column;
                align-items: center;
            }
            
            .step:not(:last-child)::after {
                display: none;
            }
            
            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .team-grid, .testimonial-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu {
                display: none;
            }
            
            .values-grid, .team-grid, .testimonial-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                flex-direction: column;
            }
            
            .footer-column {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Our Story Section -->
    <section class="content-section">
        <div class="container">
            <div class="two-column">
                <div class="image-container">
                    <img src="assets/about.jpg" alt="Casafix platform connecting homeowners and repair services">
                </div>
                <div class="text-content">
                    <h2>Our Story</h2>
                    <p>Casafix was founded in 2018 by Che Naomi, a tech entrepreneur who experienced firsthand how challenging it can be to find reliable home repair services. After a series of disappointing experiences with contractors, she decided to create a solution that would make it easier for homeowners to connect with trustworthy professionals.</p>
                    <p>What began as a small directory of vetted contractors in one city has expanded into a comprehensive platform serving homeowners across the country. Today, Casafix helps thousands of people each month find the right professionals for their home repair and renovation needs.</p>
                    <p>Our mission is simple: to take the stress out of home maintenance by connecting homeowners with skilled, reliable, and fairly priced contractor companies that connect them to these contractors through our easy-to-use digital platform.</p>
                </div>
            </div>
            
           
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>How Casafix Works</h2>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Describe Your Project</h3>
                    <p>Tell us what you need help with and provide a few details about your home repair or renovation project.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Get Matched</h3>
                    <p>Our algorithm matches you with pre-screened, qualified companies 
                        in your area who specialize in your type of project, which provide you with professionals for the job </p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Compare & Hire</h3>
                    <p>Review profiles, ratings, and quotes from multiple contractors before choosing the right one for your needs.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Complete Your Project</h3>
                    <p>Work with your chosen Company and use our platform to communicate, pay securely, and leave reviews.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="values">
        <div class="container">
            <div class="section-title">
                <h2>Our Values</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🔍</div>
                    <h3>Trust & Transparency</h3>
                    <p>We thoroughly vet all contractors on our platform and provide honest reviews and clear pricing to help you make informed decisions.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3>Quality Connections</h3>
                    <p>We focus on matching homeowners with the right professionals based on expertise, availability, and project requirements.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">⚡</div>
                    <h3>Efficiency</h3>
                    <p>Our platform streamlines the process of finding, hiring, and working with home repair professionals to save you time and reduce stress.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">💬</div>
                    <h3>Open Communication</h3>
                    <p>We facilitate clear communication between homeowners and contractor companies throughout the entire project lifecycle.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🛡️</div>
                    <h3>Security</h3>
                    <p>Our secure payment system and satisfaction guarantee protect both homeowners and contractors.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🌱</div>
                    <h3>Community Support</h3>
                    <p>We're committed to supporting local businesses and building stronger communities through quality home improvement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What People Are Saying</h2>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial">
                    <div class="testimonial-text">
                        <p>Casafix made finding a reliable plumber so easy! Within hours of submitting my request, I had three quotes from verified professionals. The platform is intuitive and I love being able to see honest reviews from other homeowners.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="Active companies/sara.jpg" alt="Sarah T." class="author-avatar">
                        <div class="author-details">
                            <h4>Sarah T.</h4>
                            <p>Homeowner in Boston</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-text">
                        <p>As a general contractor, joining Casafix has transformed my business. Their vetting process is thorough, which means customers already trust us before we even meet. The platform handles scheduling and payments smoothly.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="Active companies/migel.jpeg" alt="Miguel R." class="author-avatar">
                        <div class="author-details">
                            <h4>Miguel R.</h4>
                            <p>General Contractor</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-text">
                        <p>When my water heater broke, I needed help fast. Casafix connected me with an emergency plumber who arrived the same day. The secure payment system gave me peace of mind, and the work was excellent.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="Active companies/david.jpg" alt="David L." class="author-avatar">
                        <div class="author-details">
                            <h4>David L.</h4>
                            <p>Homeowner in Chicago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  

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
</body>
</html>