<?php

// print_r($_SESSION);
include('../includes/header.php');
require("../includes/config.php");

?>

<body>
    <a class="btn btn-primary" href="create.php" role="button">Add Artist</a>
    <h1>artists</h1>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>artist ID</th>
                <th>artist name </th>
                <th>Country</th>
                <th>Image</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM artists ORDER BY artist_id DESC";

            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
               //  var_dump($row);
                echo "<tr>
                        <td>{$row['artist_id']}</td>
                        <td>{$row['name']}</td>
                       
                        <td>{$row['country']}</td>
                        <td><img width='250' height='250' src='{$row['img_path']}' /></td>
                        <td><a href='edit.php?id={$row['artist_id']}' class='btn btn-sm btn-outline-primary' title='Edit'>
        <i class='fa-regular fa-pen-to-square' aria-hidden='true'></i>
    </a>
                                <a href='delete.php?id={$row['artist_id']}' class='btn btn-sm btn-outline-danger' title='Delete' onclick=\"return confirm('Are you sure you want to delete this artist?')\">
                                    <i class='fa-regular fa-trash-can' aria-hidden='true'></i>
                                </a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
<?php
include('../includes/footer.php');

?>