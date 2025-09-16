    <?php
    require('../includes/config.php');

    $artist_id = (int) $_POST['artistId'];
    $name = trim($_POST['artistName']);
    $country = trim($_POST['country']);

    // Default: get the current image path from DB
    $query = "SELECT img_path FROM artists WHERE artist_id = $artist_id";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $path = $row['img_path'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['image']['type'] == "image/png" || 
            $_FILES['image']['type'] == "image/jpeg" || 
            $_FILES['image']['type'] == "image/jpg") {

            $source = $_FILES['image']['tmp_name'];
            $filename = basename($_FILES['image']['name']);
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $target = "../upload/" . uniqid() . "." . $ext;

            move_uploaded_file($source, $target) or die("Couldn't copy");

            $size = getImageSize($target);
            $imgstr = "<p><img width=\"$size[0]\" height=\"$size[1]\" src=\"$target\" alt=\"uploaded image\" /></p>";
            echo $imgstr;

            // update path only if new image uploaded
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
