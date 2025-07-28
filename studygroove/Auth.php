<?php
session_start();
$servername = "localhost";
$username = "root";
$pw = "";
$database = "newcollegemanagement";

// Create connection
$conn = new mysqli($servername, $username, $pw, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // LOGIN OPERATION
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use prepared statements to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $user['email']; // Correct here
                header("Location: indexls.php");
                exit();
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "No user found with this email!";
        }

        $stmt->close();
    } elseif (isset($_POST['signup'])) {
        // SIGNUP OPERATION
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Use prepared statements to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Use prepared statements to insert data
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password);
            if ($stmt->execute()) {
                $_SESSION['email'] = $email; // Fixed the error here
                header("Location: indexls.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Email already exists!";
        }

        $stmt->close();
    }
}

$conn->close();
?>
