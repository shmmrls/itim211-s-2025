<?php
include("../includes/header.php");
include "../includes/config.php";
?>
<div class="container-fluid container-lg">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="mb-0">Albums</h3>
        <a class="btn btn-primary" href="create.php" role="button">Add Album</a>
    </div>

    <!-- align-middle makes table cell content vertically centered -->
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Album ID</th>
                <th>Album Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Date Released</th>
                <!-- give action column a fixed width and right-align -->
                <th class="text-end" style="width:140px;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $today = date("Y-m-d");
        $result = mysqli_query($conn, "SELECT * FROM albums al INNER JOIN artists ar ON (al.artist_id = ar.artist_id) ORDER BY al.album_id");

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['album_id']}</td>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['genre']}</td>";
            echo "<td>{$row['date_released']}</td>";

            // keep buttons right-aligned and vertically centered
            echo "<td class='text-end'>
                    <div class='d-flex justify-content-end align-items-center gap-2'>";

            if ($row['date_released'] >= $today) {
                echo "<a href='edit.php?id={$row['album_id']}' class='btn btn-sm btn-outline-primary' title='Edit'>
                        <i class='fa-regular fa-pen-to-square' aria-hidden='true'></i>
                      </a>";
            } else {
                // placeholder keeps spacing consistent when Edit is hidden
                echo "<a class='btn btn-sm btn-outline-primary invisible' aria-hidden='true'>
                        <i class='fa-regular fa-pen-to-square' aria-hidden='true'></i>
                      </a>";
            }

            echo "    <a href='delete.php?id={$row['album_id']}' class='btn btn-sm btn-outline-danger' title='Delete' onclick=\"return confirm('Are you sure you want to delete this album?');\">
                        <i class='fa-regular fa-trash-can' aria-hidden='true'></i>
                      </a>
                    </div>
                  </td>";

            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>
