<?php
session_start();
require('../includes/config.php');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please login to access this page.";
    header("Location: ../user/login.php");
    exit();
}

// ✅ Check if an ID is passed
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$artist_id = (int) $_GET['id'];

// ✅ Delete albums linked to this artist first
mysqli_query($conn, "DELETE FROM albums WHERE artist_id = $artist_id");

// ✅ Delete the artist
$sql = "DELETE FROM artists WHERE artist_id = $artist_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
    header("Location: index.php");
    exit;
} else {
    echo "❌ Failed to delete artist.";
}
?>
