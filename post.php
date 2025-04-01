<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Post Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: white;
        }
        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-container input, .form-container select, .form-container textarea, .form-container button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Post a New Service</h1>
        <form action="services.php" method="POST" enctype="multipart/form-data">
            <label for="service-name">Service Name:</label>
            <input type="text" id="service-name" name="service-name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="icon">Upload Icon:</label>
            <input type="file" id="icon" name="icon" accept="image/svg+xml" width="200px"required>

            <label for="providers">Service Providers (up to 5):</label>
            <input type="text" id="provider1" name="providers[]" placeholder="Provider 1" required>
            <input type="text" id="provider2" name="providers[]" placeholder="Provider 2">
            <input type="text" id="provider3" name="providers[]" placeholder="Provider 3">
            <input type="text" id="provider4" name="providers[]" placeholder="Provider 4">
            <input type="text" id="provider5" name="providers[]" placeholder="Provider 5">

            <button type="submit">Post Service</button>
        </form>
    </div>
</body>
</html>