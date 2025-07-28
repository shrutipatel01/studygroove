<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "newcollegemanagement";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// connect.php
/*try {
    $conn = new PDO('mysql:host=your_host;dbname=new', 'username', 'password');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
*/

?>
