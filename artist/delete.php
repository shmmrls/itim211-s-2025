<?php
require('../includes/config.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$artist_id = (int) $_GET['id'];

mysqli_query($conn, "DELETE FROM albums WHERE artist_id = $artist_id");

$sql = "DELETE FROM artists WHERE artist_id = $artist_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
    header("Location: index.php");
    exit;
} else {
    echo "❌ Failed to delete artist.";
}
