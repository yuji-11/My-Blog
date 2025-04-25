<?php
include 'db.php';

$post_id = $_POST['post_id'];
$name = $_POST['name'];
$comment = $_POST['comment'];

$stmt = $conn->prepare("INSERT INTO comments (post_id, name, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $post_id, $name, $comment);
$stmt->execute();

header("Location: post.php?id=" . $post_id);
exit;
?>
