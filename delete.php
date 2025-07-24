<?php
require_once('connection.php');
$conn = dbConnect();

$id = $_GET['id'];
$conn->query("DELETE FROM blog_posts WHERE id = $id");

header("Location: index.php");
?>
