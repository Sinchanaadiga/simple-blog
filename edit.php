<?php
require_once('connection.php');
$conn = dbConnect();
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $tags = $_POST['tags'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE blog_posts SET title=?, body=?, tags=?, category=? WHERE blog_id=?");
    $stmt->bind_param("ssssi", $title, $body, $tags, $category, $id);
    $stmt->execute();
    header("Location: index.php");
}

$post = $conn->query("SELECT * FROM blog_posts WHERE blog_id=$id")->fetch_assoc();
?>

<form method="POST">
  <input type="text" name="title" value="<?= $post['title'] ?>"><br>
  <input type="text" name="tags" value="<?= $post['tags'] ?>"><br>
  <input type="text" name="category" value="<?= $post['category'] ?>"><br>
  <textarea name="body" id="editor"><?= $post['body'] ?></textarea><br>
  <button type="submit">Update Post</button>
</form>

<script src="assets/vendors/ckeditor/ckeditor.js"></script>
<script>CKEDITOR.replace('editor');</script>
