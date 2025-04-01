<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/newestlogo.jpg">
    <title>Welcome to CasaFix</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --yellow: #FFD700;
            --black: #222222;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }
        
        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--white);
            z-index: 1000;
            transition: all 0.5s ease-out;
        }
        
        .loader {
            position: relative;
            width: 120px;
            height: 120px;
        }
        
        .house-icon {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            font-size: 70px;
            color: var(--black);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }
        
        .circle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 6px solid var(--light-gray);
            border-top: 6px solid var(--yellow);
            border-radius: 50%;
            animation: spin 2s linear infinite;
        }
        
        .welcome-text {
            margin-top: 2rem;
            font-size: 1.8rem;
            color: var(--black);
            font-weight: 600;
            text-align: center;
            letter-spacing: 1px;
        }
        
        .welcome-subtext {
            margin-top: 0.5rem;
            font-size: 1rem;
            color: #666;
            text-align: center;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Start Journey Button Styles */
        .journey-button-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 900;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
        }
        
        .journey-button {
            background-color: var(--yellow);
            color: var(--black);
            padding: 1.2rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .journey-button:hover {
            background-color: var(--black);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
        
        .journey-button i {
            margin-left: 10px;
            font-size: 1.1rem;
        }
        a{
            text-decoration:none;
        }
        
        /* Show button animation */
        .journey-show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Button animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .button-animation {
            animation: pulse 2s infinite;
        }
        
        /* Arrow animation */
        @keyframes bounceRight {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(5px); }
        }
        
        .arrow-animation {
            animation: bounceRight 1.5s infinite;
        }
        
        /* Responsive adjustments */
        @media (max-width: 480px) {
            .loader {
                width: 90px;
                height: 90px;
            }
            
            .house-icon {
                font-size: 50px;
            }
            
            .welcome-text {
                font-size: 1.5rem;
            }
            
            .journey-button {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
        }
        
        .hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .removed {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Loader Section -->
    <div class="loader-container" id="loaderContainer">
        <div class="loader">
            <div class="circle"></div>
            <div class="house-icon">
                <img src="assets/newestlogo.jpg" width="50px" style="border-radius:50%; height:70px;">
            </div>
        </div>
        <h1 class="welcome-text">Welcome to CasaFix</h1>
        <p class="welcome-subtext">Your home repairs solution</p>
    </div>
    
    <!-- Start Journey Button -->
    <div class="journey-button-container" id="journeyButtonContainer">
       <a href="landingpage.php"> <button id="startJourneyBtn" class="journey-button button-animation">
            Start Your Journey
            <i class="fas fa-long-arrow-alt-right arrow-animation"></i>
        </button></a>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loaderContainer = document.getElementById('loaderContainer');
            const journeyButtonContainer = document.getElementById('journeyButtonContainer');
            const startJourneyBtn = document.getElementById('startJourneyBtn');
            
            // Add click event listener to the button
            startJourneyBtn.addEventListener('click', function() {
                window.location.href = 'landingpage.php';
            });
            
            // Set timeout for exactly 4 seconds
            setTimeout(function() {
                // First fade out the loader
                loaderContainer.classList.add('hidden');
                
                // After transition completes, remove loader and show button
                setTimeout(function() {
                    loaderContainer.classList.add('removed');
                    journeyButtonContainer.classList.add('journey-show');
                }, 500);
            }, 4000); // 4 seconds
        });
    </script>
</body>
</html>