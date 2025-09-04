<?php
require('../includes/config.php');

$artist_id = (int) $_POST['artistId'];
$name = trim($_POST['artistName']);
$country = trim($_POST['country']);

$path = ""; // default, in case no file uploaded

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    if ($_FILES['image']['type'] == "image/png" || 
        $_FILES['image']['type'] == "image/jpeg" || 
        $_FILES['image']['type'] == "image/jpg") {

        $source = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        //$filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $filename); 
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $target = "../upload/" . uniqid() . "." . $ext;

        move_uploaded_file($source, $target) or die("Couldn't copy");

        $size = getImageSize($target);
        $imgstr = "<p><img width=\"$size[0]\" height=\"$size[1]\" src=\"$target\" alt=\"uploaded image\" /></p>";
        echo $imgstr;

        $path = $target;
    }
}

$sql = "UPDATE artists 
        SET name = '{$name}', country = '{$country}', img_path = '{$path}' 
        WHERE artist_id = $artist_id";

$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: index.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
