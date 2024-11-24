
<?php
session_start();
include 'db/connection.php';

if (isset($_GET['id'])) {
    $file_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM files WHERE id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
