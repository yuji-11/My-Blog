<?php
include('db_config.php');

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "INSERT INTO posts (name, title, content, date_posted) VALUES ('$name', '$title', '$content', NOW())";

    if (mysqli_query($conn, $sql)) {
        $success = true;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Blog Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Add a New Blog Post</h1>
</header>

<div class="blog-form">
    <?php if ($success): ?>
        <div class="success-message">
            <p>New blog post added successfully.</p>
            <a href="index.php" class="back-btn">Go Back to Home</a>
        </div>
    <?php else: ?>
        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="title">Post Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="content">Post Content:</label>
            <textarea name="content" id="content" rows="10" required></textarea>

            <button type="submit">Submit Post</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

