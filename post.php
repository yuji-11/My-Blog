<?php
include('db_config.php');

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $content = $row['content'];
        $author = $row['name'];
        $date = $row['date_posted'];
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid post ID.";
    exit;
}

// Handle comment submission
$commentSuccess = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_submit'])) {
    $comment_name = mysqli_real_escape_string($conn, $_POST['comment_name']);
    $comment_message = mysqli_real_escape_string($conn, $_POST['comment_message']);

    $sql_comment = "INSERT INTO comments (post_id, name, message) VALUES ($post_id, '$comment_name', '$comment_message')";
    if (mysqli_query($conn, $sql_comment)) {
        $commentSuccess = true;
    }
}

// Get comments
$comments = [];
$comment_query = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY date_posted DESC";
$comment_result = mysqli_query($conn, $comment_query);
while ($comment = mysqli_fetch_assoc($comment_result)) {
    $comments[] = $comment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1><?php echo htmlspecialchars($title); ?></h1>
</header>

<div class="post-view">
    <p class="meta"><strong>By:</strong> <?php echo htmlspecialchars($author); ?> | <strong>Date:</strong> <?php echo $date; ?></p>
    <div class="post-content">
        <?php echo nl2br(htmlspecialchars($content)); ?>
    </div>
</div>

<div class="comments-section">
    <h2>Comments</h2>

    <?php if ($commentSuccess): ?>
        <p class="success-message">Your comment has been added!</p>
    <?php endif; ?>

    <?php if (count($comments) > 0): ?>
        <?php foreach ($comments as $c): ?>
            <div class="comment">
                <p><strong><?php echo htmlspecialchars($c['name']); ?></strong> (<?php echo $c['date_posted']; ?>)</p>
                <p><?php echo nl2br(htmlspecialchars($c['message'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>

    <h3>Leave a Comment</h3>
    <form method="POST">
        <input type="text" name="comment_name" placeholder="Your Name" required><br>
        <textarea name="comment_message" rows="4" placeholder="Your Comment" required></textarea><br>
        <button type="submit" name="comment_submit">Post Comment</button>
    </form>
</div>

</body>
</html>


