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
        <button class="login-btn">LOG OUT</button>

        
    </nav>
</header>

<script src="./script.js"></script>

</body>
</html>
