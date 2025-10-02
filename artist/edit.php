<?php
// session_start();
include('../includes/header.php');
require('../includes/config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "⚠️ Please login to access this page.";
    header("Location: ../user/login.php");
    exit();
}

// Validate and fetch artist
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$artist_id = (int) $_GET['id'];
$sql = "SELECT * FROM artists WHERE artist_id = $artist_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "❌ Artist not found.";
    exit();
}
?>

<!-- Full height flex container -->
<div class="d-flex flex-column min-vh-100">

    <!-- Main content -->
    <div class="container-fluid container-lg flex-grow-1">

        <form action="update.php" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="artistName">Artist name</label>
                <input type="text" class="form-control" id="artistName" name="artistName" 
                       placeholder="Enter name" value="<?php echo $row['name']; ?>" />
            </div>

            <div class="form-group mb-3">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" 
                       placeholder="Artist country" value="<?php echo $row['country']; ?>" />
            </div>

            <div class="form-group mb-3">
                <label for="image">Upload image</label>
                <input type="file" class="form-control" id="image" name="image">
                <div class="mt-2">
                    <img width="250" height="250" src="<?php echo $row['img_path']; ?>" />
                </div>
            </div>

            <input type="hidden" name="artistId" value="<?php echo $row['artist_id']; ?>" />

            <!-- Buttons aligned right with spacing -->
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary btn-sm me-2">Submit</button>
                <a href="index.php" class="btn btn-secondary btn-sm">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Footer always at bottom -->
    <?php include('../includes/footer.php'); ?>
</div>
