<?php
session_start();
require 'connection.php';
$files = array_diff(scandir(''), array('..', '.')); 

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
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Uploaded Files</h1>

        <ul>
            <?php
            if (count($files) > 0) {
                foreach ($files as $file) {
                    echo "<li><a href='$file' target='_blank'>$file</a></li>";
                }
            } else {
                echo "<li>No files uploaded yet.</li>";
            }
            ?>
        </ul>

        <a href="upload.php">Upload more files</a>
    </div>
</body>
</html>
