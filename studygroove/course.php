<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$uploadDir = 'uploads/'; // Directory where files will be uploaded
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Allowed file types
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['material'])) {
    // Check for upload errors
    if ($_FILES['material']['error'] !== UPLOAD_ERR_OK) {
        $message = "Upload error: " . $_FILES['material']['error'];
    } else {
        // Validate the file type
        $fileType = mime_content_type($_FILES['material']['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $message = "File type is not allowed.";
        } else {
            // Generate a unique file name
            $fileName = uniqid('file_', true) . '_' . basename($_FILES['material']['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['material']['tmp_name'], $targetFilePath)) {
                $message = "The file " . htmlspecialchars($fileName) . " has been uploaded.";
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}

// Get uploaded files, excluding current and parent directory entries
$files = array_diff(scandir($uploadDir), array('..', '.')); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material - CodingStella</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <!-- Same Navbar as index.php -->
    </header>

    <main>
        <h1>Learning Materials</h1>
        
        <?php if ($message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="material" required>
            <button type="submit">Upload Material</button>
        </form>

        <h2>Uploaded Materials</h2>
        <ul>
            <?php foreach ($files as $file): ?>
                <li><a href="<?php echo $uploadDir . htmlspecialchars($file); ?>" target="_blank"><?php echo htmlspecialchars($file); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2024 CodingStella. All rights reserved.</p>
    </footer>
</body>
</html>