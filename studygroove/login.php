<?php
session_start();

// Predefined username and password
$valid_username = 'charusat'; // Replace with your username
$valid_password = 'charusat123'; // Replace with your password

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Set session variable and redirect to the dashboard
        $_SESSION['username'] = $username;
        header("Location: admin_dashboard.php"); // Change to your desired page
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        header {
            width: 100%;
            background-color: #007BFF; /* Blue for header */
            padding: 15px 20px; /* Padding for header */
            position: absolute;
            top: 0;
        }

        header h1 {
            margin: 0;
            font-size: 28px; /* Bigger font size for header */
            font-weight: bold; /* Make title bold */
            color: white; /* White text color */
            text-align: left; /* Align text to the left */
        }

        .login-container {
            background: #fff;
            padding: 40px;  /* Increased padding */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px;  /* Wider box */
            text-align: center;  /* Center text */
            position: relative; /* To stack over background */
            z-index: 1; /* Ensure it is above the background */
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;  /* Bigger font size for login title */
            font-weight: bold; /* Make login title bold */
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;  /* Bold labels */
        }

        .input-group input {
            width: 100%;
            padding: 12px;  /* Increased padding for inputs */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;  /* Larger font size for inputs */
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .login-button {
            background-color: #007BFF;
            color: white;
            padding: 12px;  /* Increased button padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;  /* Larger button font size */
            transition: background 0.3s;
        }

        .login-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1> <!-- Header title -->
    </header>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
</body>
</html>