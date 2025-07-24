<?php
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = dbConnect();

    $title = $_POST['title'];
    $body = $_POST['body'];
    $tags = $_POST['tags'];
    $category = $_POST['category'];

    // Handle image upload
    $imageName = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadPath = 'upload/' . $imageName;
        move_uploaded_file($imageTmp, $uploadPath);
    }

    $stmt = $conn->prepare("INSERT INTO blog_posts (title, body, image, tags, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $body, $imageName, $tags, $category);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Blog</title>
    <link rel="stylesheet" href="style.css">
    <script src="vendors/ckeditor/ckeditor.js"></script>
</head>
<body>
    <h2>Create a New Blog Post</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Enter title" required><br><br>

        <textarea name="body" id="editor"></textarea><br><br>

        <input type="file" name="image" required><br><br>

        <input type="text" name="tags" placeholder="Enter tags (comma-separated)"><br><br>

        <select name="category" required>
            <option value="Tech">Tech</option>
            <option value="Lifestyle">Lifestyle</option>
            <option value="News">News</option>
        </select><br><br>

        <button type="submit">Publish</button>
    </form>

    <script>
        CKEDITOR.replace('editor');
    </script>
</body>
</html>
