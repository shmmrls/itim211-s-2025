<?php
require('../includes/config.php');
// print_r($_FILES);
// yis galing
$name = trim($_POST['artistName']);
$country = trim($_POST['country']);
print "<h1>$name</h1>";

if (isset($_FILES['image'])) {

    if ($_FILES['image']['type'] == "image/png" || 
    $_FILES['image']['type'] == "image/jpeg" || 
    $_FILES['image']['type'] == "image/jpg") {


        $source = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        //$filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $filename); 
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $target = "../upload/" . uniqid() . "." . $ext;
       
        move_uploaded_file($source, $target) or die("Couldn't copy");
        $size = getImageSize($target);

        $imgstr = "<p><img width=\"$size[0]\" height=\"$size[1]\" ";
        $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";

        print $imgstr;
    }

    $sql = "INSERT INTO artists (name,country,img_path) VALUES('$name', '$country','$target')";
    print $sql;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: index.php");
    }
}
