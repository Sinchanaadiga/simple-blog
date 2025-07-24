<?php
require_once('connection.php');
$conn = dbConnect();
$posts = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>SimpleBlog</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/bootstrap-icons/bootstrap-icons.css">
  <style>
   body {
  background-image: url('assets/blog.jpg'); /* Replace with your actual image path */
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  color: white;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  text-align: center;
}

   .hero {
  position: absolute;
  top: 50%;
  left: 5%;
  transform: translateY(-50%);
  text-align: left;
  max-width: 700px;
}
.hero h1 {
  font-size: 48px;
  margin-bottom: 20px;
  color: white;
}
.hero p {
  font-size: 20px;
  margin-bottom: 30px;
  color: #e0e0e0;
}
    .btn-blog {
      background-color: orange;
      color: white;
      padding: 15px 30px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      text-decoration: none;
    }
    .post-card {
      background: white;
      color: #333;
      margin: 20px auto;
      padding: 20px;
      border-radius: 10px;
      width: 80%;
      text-align: left;
    }
    .post-card img {
      max-width: 100%;
      height: auto;
      margin-top: 10px;
    }
    hr {
      border-top: 1px solid white;
    }
  </style>
</head>
<body>

<div class="hero">
  <h1>Publish your passions, your way</h1>
  <p>Create a unique and beautiful blog easily.</p>
  <a class="btn-blog" href="create.php">+ CREATE YOUR BLOG</a>
</div>


<?php while($post = $posts->fetch_assoc()): ?>
  <div class="post-card">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <small><?= date("M d, Y", strtotime($post['created_at'])) ?></small>
    <p><?= substr(strip_tags($post['body']), 0, 150) ?>...</p>
    <?php if (!empty($post['image'])): ?>
      <img src="upload/<?= htmlspecialchars($post['image']) ?>" alt="Post Image">
    <?php endif; ?>
    <div>
      <small><b>Tags:</b> <?= htmlspecialchars($post['tags']) ?> | <b>Category:</b> <?= htmlspecialchars($post['category']) ?></small>
    </div>
    <a href="edit.php?id=<?= $post['id'] ?>">Edit</a> | 
    <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
  </div>
<?php endwhile; ?>

</body>
</html>
