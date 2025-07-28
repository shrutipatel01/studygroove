<?php
session_start();
include('connect.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // Validate file upload
        if ($file['error'] === UPLOAD_ERR_OK) {
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . basename($file['name']);
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Allow certain file formats (e.g., pdf, docx, mp4)
            $allowedTypes = array("pdf", "docx", "mp4");
            if (in_array($fileType, $allowedTypes)) {
                // Attempt to move the uploaded file
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    echo "The file ". htmlspecialchars(basename($file['name'])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only PDF, DOCX, & MP4 files are allowed.";
            }
        } else {
            echo "File upload error!";
        }
    }
}
$conn->close();
?>
