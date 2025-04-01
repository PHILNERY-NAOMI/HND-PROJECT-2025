<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/newestlogo.jpg">
    <title>User or Company Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button {
            padding: 12px 0;
            margin:10px;
            width: 48%;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        a{
            color:#000;
            text-decoration:none;
        }
        .user-btn {
            background-color: #4CAF50;
            color: white;
        }
        .company-btn {
            background-color: #2196F3;
            color: white;
        }
        .user-btn:hover {
            background-color: #3e8e41;
        }
        .company-btn:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Select Account Type</h2>
        <p>Please select the type of account you would like to create:</p>
        <div class="button-container">
            <button class="user-btn" type="button"><a href="user_login.php">User</a></button>
            <button class="company-btn" type="button"><a href="company_login.php">Company</a></button>
            <button class="company-btn" type="button"><a href="adminlogin.php">Admin</a></button>
        </div>
    </div>
</body>
</html>