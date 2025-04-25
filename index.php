<?php
include('db_config.php');

$sql = "SELECT * FROM posts ORDER BY date_posted DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Welcome to My Blog</h1>
    </header>

    <!-- Recent Posts Section -->
    <div class="blog-listing">
        <h2>Recent Posts</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='blog-item'>";
                echo "<h3><a href='post.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></h3>";
                echo "<p><strong>By: </strong>" . htmlspecialchars($row['name']) . "</p>"; // Display author name
                echo "<p>" . substr($row['content'], 0, 150) . "...</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No posts available.</p>";
        }
        ?>

        <!-- Link to Add a New Post -->
        <a href="add_post.php" class="add-post-link">Add a New Post</a>
    </div>

</body>
</html>

