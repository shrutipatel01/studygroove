<?php
// Start session to check if the user is logged in
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website with Login & Registration Form</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0'>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<header>
    <nav class="navbar">
        <span class="hamburger-btn material-symbols-rounded">menu</span>
        <ul class="links">
            <span class="close-btn material-symbols-rounded">close</span>
            <li><a href="">Home</a></li>
            <li><a href="course.html">Courses</a></li>
            <li><a href="material.php">Material</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="login.php">Admin Panel</a></li>
        </ul>
        <button class="login-btn">LOG IN</button>

        
    </nav>
</header>

<div class="blur-bg-overlay"></div>

<!-- Login Form -->
 
<div class="form-popup">
    <span class="close-btn material-symbols-rounded">close</span>
    <div class="form-box login">
        <div class="form-content">
            <h2>LOGIN</h2>
            <form action="Auth.php" method="POST">
                <input type="hidden" name="login" value="1">
                <div class="input-field">
                    <input type="text" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit">Log In</button>
            </form>
            <div class="bottom-link">
                Don't have an account?
                <a href="#" id="signup-link">Signup</a>
            </div>
        </div>
    </div>

    <!-- Signup Form -->
    <div class="form-box signup">
        <div class="form-content">
            <h2>SIGNUP</h2>
            <form action="Auth.php" method="POST">
                <input type="hidden" name="signup" value="1">
                <div class="input-field">
                    <input type="text" name="email" required>
                    <label>Enter your email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Create password</label>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <div class="bottom-link">
                Already have an account?
                <a href="#" id="login-link">Login</a>
            </div>
        </div>
    </div>
</div>

<script src="./script.js"></script>

</body>
</html>
