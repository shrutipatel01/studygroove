<?php
session_start();
include('connect.php'); // Ensure this includes a valid MySQLi connection

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $documentName = $_POST['document_name'];
    $file = $_FILES['document'];

    // Define the target directory for uploads
    $targetDir = 'uploads/';
    $targetFile = $targetDir . basename($file['name']);

    // Check if file already exists
    if (file_exists($targetFile)) {
        $error = "File already exists.";
    } elseif ($file['size'] > 500000) {
        $error = "File is too large.";
    } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO documents (document_name, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $documentName, $targetFile);
            if ($stmt->execute()) {
                $success = "Document uploaded successfully.";
            } else {
                $error = "Error uploading document.";
            }
            $stmt->close();
        } else {
            $error = "Error uploading file.";
        }
    }
}

// Handle document update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $newName = $_POST['new_name'];

    // Update document name in the database
    $stmt = $conn->prepare("UPDATE documents SET document_name = ? WHERE id = ?");
    $stmt->bind_param("si", $newName, $id);
    if ($stmt->execute()) {
        $success = "Document name updated successfully.";
    }
    $stmt->close();
}

// Handle document deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Retrieve file path from database
    $stmt = $conn->prepare("SELECT file_path FROM documents WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();

    if ($document) {
        // Delete file from server
        unlink($document['file_path']);

        // Delete from database
        $stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $success = "Document deleted successfully.";
    }
    $stmt->close();
}

// Fetch all documents
$result = $conn->query("SELECT * FROM documents");
$documents = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin File Management</title>
    
    <style>
          body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar {
            display: flex;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .navbar a:hover {
            background-color: #0056b3;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .message, .error {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        .upload-button, .update-button {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .upload-button:hover, .update-button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            color: red;
            cursor: pointer;
        }
    </style>
</head>


<body>
<header>
    <div class="navbar">
        
        <nav>
            <a href="index.php">Home</a>
            <a href="courses.html">Courses</a>
            <a href="material.php">Materials</a>
            <a href="about.php">About Us</a>
            
        </nav>
    </div>
</header>
    <div class="container">
        <h2>Admin File Management</h2>

        <?php if (isset($success)): ?>
            <p class="message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="document_name" placeholder="Document Name" required>
            <input type="file" name="document" required>
            <button type="submit" class="upload-button">Upload Document</button>
        </form>

        <h3>Uploaded Documents</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Document Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($documents as $document): ?>
                <tr>
                    <td><?php echo htmlspecialchars($document['id']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="text" name="new_name" placeholder="New Name" required>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($document['id']); ?>">
                            <button type="submit" name="update" class="update-button">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="<?php echo htmlspecialchars($document['file_path']); ?>" target="_blank">Download</a> |
                        <a href="?delete=<?php echo htmlspecialchars($document['id']); ?>" class="delete-button">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
