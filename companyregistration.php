<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Company Registration</h1>
        <form action="provider_register.php" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name:</label>
                <input type="text" name="company_name" class="form-control" required>
                <div class="invalid-feedback">Please enter your company's name.</div>
            </div>

            <div class="mb-3">
                <label for="manager_name" class="form-label">Manager Name:</label>
                <input type="text" name="manager_name" class="form-control" required>
                <div class="invalid-feedback">Please enter the manager's name.</div>
            </div>

            <div class="mb-3">
                <label for="town" class="form-label">Town:</label>
                <input type="text" name="town" class="form-control" required>
                <div class="invalid-feedback">Please enter your town.</div>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
                <input type="text" name="country" class="form-control" required>
                <div class="invalid-feedback">Please enter your country.</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
                <div class="invalid-feedback">Please enter a valid email.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (min 8 characters):</label>
                <input type="password" name="password" class="form-control" minlength="8" required>
                <div class="invalid-feedback">Password must be at least 8 characters long.</div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" minlength="8" required>
                <div class="invalid-feedback">Passwords do not match.</div>
            </div>

            <button type="submit" class="btn btn-custom w-100">Register</button>
            Already have account <a href="company_login.php">Login</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable Bootstrap validation
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Confirm password validation
        const password = document.querySelector('input[name="password"]');
        const confirmPassword = document.querySelector('input[name="confirm_password"]');
        confirmPassword.addEventListener('input', () => {
            if (confirmPassword.value !== password.value) {
                confirmPassword.setCustomValidity("Passwords do not match.");
            } else {
                confirmPassword.setCustomValidity("");
            }
        });
    </script>
</body>
</html>