<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$upload_dir = $username . '/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $file_name = $_FILES['fileToUpload']['name'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_error = $_FILES['fileToUpload']['error'];

    if ($file_error === UPLOAD_ERR_OK) {
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_exts = ['jpg', 'png', 'pdf', 'docx', 'txt'];

        if (in_array(strtolower($file_ext), $allowed_exts)) {
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $target_file = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $target_file)) {
                echo "<script>alert('File uploaded successfully!');</script>";
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Allowed: jpg, png, pdf, docx, txt.');</script>";
        }
    } else {
        echo "<script>alert('Error in file upload. Please try again.');</script>";
    }
}


if (isset($_GET['delete'])) {
    $file_to_delete = $upload_dir . $_GET['delete'];

    if (file_exists($file_to_delete)) {
        unlink($file_to_delete);
        echo "<script>alert('File deleted successfully.');</script>";
    } else {
        echo "<script>alert('File not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyBF8YtBtv5aJATAafjP1hVptFyS6K8dpF0",
    authDomain: "filehaven-fa360.firebaseapp.com",
    projectId: "filehaven-fa360",
    storageBucket: "filehaven-fa360.firebasestorage.app",
    messagingSenderId: "1048999785907",
    appId: "1:1048999785907:web:ff62541608c50dd7c187c6",
    measurementId: "G-4JRPQ6NFFB"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #67b26f, #4ca2cd);
            color: white;
        }

        nav {
            background-color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .user-status {
            font-size: 14px;
        }

        .form-container {
            max-width: 400px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #333;
        }

        .form-container h2 {
            text-align: center;
            color: #4ca2cd;
        }

        .form-container input[type="file"],
        .form-container button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .form-container button {
            background-color: #4ca2cd;
            color: white;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #67b26f;
        }

        .file-list {
            max-width: 800px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #333;
        }

        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .file-item {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .file-item a {
            text-decoration: none;
            color: #4ca2cd;
        }

        .file-item a:hover {
            text-decoration: underline;
        }

        .file-item .actions {
            margin-top: 10px;
        }

        .file-item .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #67b26f;
        }

        .file-item .actions a:hover {
            color: #4ca2cd;
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="user-status">Signed in as: <?php echo htmlspecialchars($username); ?></div>
    </nav>

    <div class="form-container">
        <h2>Upload Your File</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" required>
            <button type="submit">Upload File</button>
        </form>
    </div>

    <div class="file-list">
        <h3>Your Uploaded Files</h3>
        <div class="file-grid">
            <?php
            $files = array_diff(scandir($upload_dir), ['.', '..']);
            if (!empty($files)) {
                foreach ($files as $file) {
                    $file_path = $upload_dir . $file;
                    $file_size = round(filesize($file_path) / 1024, 2); 
                    echo "<div class='file-item'>
                        <p><strong>$file</strong></p>
                        <p>Size: {$file_size} KB</p>
                        <div class='actions'>
                            <a href='$file_path' download>Download</a>
                            <a href='upload.php?delete=$file' onclick='return confirm(\"Are you sure you want to delete this file?\")'>Delete</a>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No files uploaded yet.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
