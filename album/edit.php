<?php
// session_start();
include("../includes/header.php");
include("../includes/config.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "⚠️ Please login to access this page.";
    header("Location: ../user/login.php");
    exit();
}

// Validate album ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$album_id = (int) $_GET['id'];
$album = mysqli_query($conn, "SELECT * FROM albums al 
                              INNER JOIN artists ar ON (al.artist_id = ar.artist_id) 
                              WHERE album_id = $album_id LIMIT 1");
$album = mysqli_fetch_assoc($album);

if (!$album) {
    echo "❌ Album not found.";
    exit();
}

$artists = mysqli_query($conn, "SELECT * FROM artists WHERE artist_id != {$album['artist_id']}");
?>

<!-- Full height flex container -->
<div class="d-flex flex-column min-vh-100">

    <!-- Main content -->
    <div class="container-fluid container-lg flex-grow-1">
        <form action="update.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Album Name</label>
                <input type="text" class="form-control" id="name" name="albumName" 
                       value="<?php echo $album['title']; ?>">
            </div>

            <div class="mb-3">
                <label for="artist" class="form-label">Artist</label>
                <select class="form-select" id="artist" name="artist_id">
                    <?php
                    echo "<option value={$album['artist_id']} selected>{$album['name']}</option>";
                    while ($row = mysqli_fetch_assoc($artists)) {
                        echo "<option value={$row['artist_id']}>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="dateReleased" class="form-label">Date Released</label>
                <input type="date" class="form-control" id="dateReleased" 
                       name="dateReleased" value="<?php echo $album['date_released']; ?>">
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" 
                       name="genre" value="<?php echo $album['genre']; ?>">
            </div>

            <input type="hidden" id="albumId" name="albumId" value="<?php echo $album['album_id']; ?>">

            <!-- Right aligned with spacing -->
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Footer sticks to bottom -->
    <?php include("../includes/footer.php"); ?>
</div>
