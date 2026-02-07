<?php
session_start();
if(!isset($_SESSION['user_Id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_Id'];

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'blog_db';
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("<p class='error'>❌ Connection failed: " . $conn->connect_error . "</p>");
}

$post_Id = intval($_GET['post_Id'] ?? 0);
if ($post_Id <= 0) {
    die("<p class='error'>❌ Invalid Post ID.</p>");
}

// Fetch post for this user only
$stmt = $conn->prepare("SELECT * FROM posts WHERE post_Id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_Id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    die("<p class='error'>❌ Post not found or you don't have permission to edit it.</p>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['Title'] ?? '');
    $content = trim($_POST['Content'] ?? '');
    $description = trim($_POST['Description'] ?? '');
    $image = '';

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $target = "uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $post['image'];
    }

    if ($title === '' || $content === '') {
        echo "<p class='error'>❌ Title and Content are required.</p>";
    } else {
        // Correct bind_param types: s = string, i = integer
        $stmt = $conn->prepare("UPDATE posts SET Title = ?, Content = ?, image = ?, Description = ? WHERE post_Id = ? AND user_id = ?");
        $stmt->bind_param("ssssii", $title, $content, $image, $description, $post_Id, $user_id);

        if ($stmt->execute()) {
            echo "<p class='success'>✅ Post updated successfully!</p>";
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'edupdate.php';
                    }, 2000);
                  </script>";
        } else {
            echo "<p class='error'>❌ Update Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit / Update Post</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f8f9fa; }
.sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 220px; background: #1f2a38; padding: 1.5rem 1rem; display: flex; flex-direction: column; gap: 1rem; color: #ecf0f1; }
.sidebar h3 { margin-bottom: 2rem; font-weight: 600; font-size: 1.6rem; text-align: center; letter-spacing: 1px; }
.sidebar a { color: #ecf0f1; text-decoration: none; padding: 0.75rem 1rem; border-radius: 6px; transition: all 0.2s; }
.sidebar a:hover, .sidebar a.active { background: #34495e; font-weight: 600; }
.dashboard-content { margin-left: 220px; padding: 3rem 2rem; background: linear-gradient(135deg, #f8f9fa, #e3d4ff, #ffd4f1); background-size: 300% 300%; animation: gradientShift 10s ease infinite; min-height: 100vh; }
@keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
form { max-width: 600px; margin: 30px auto; display: flex; flex-direction: column; gap: 15px; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
input, textarea, button { padding: 10px; font-size: 16px; border: 1px solid #9b4dca; border-radius: 5px; }
textarea { height: 120px; resize: vertical; }
button { background: linear-gradient(90deg, #9b4dca, #d46cf0); color: white; font-weight: 600; cursor: pointer; }
button:hover { background: #8e24aa; box-shadow: 0 0 8px #8e24aa; }
img { border-radius: 8px; border: 2px solid #f1f1f1; margin-top: 5px; }
.success { color: green; font-weight: bold; text-align: center; margin-top: 10px; }
.error { color: red; font-weight: bold; text-align: center; margin-top: 10px; }
@media (max-width: 768px) { .sidebar { position: relative; width: 100%; height: auto; } .dashboard-content { margin-left: 0; padding: 1.5rem; } }
</style>
</head>
<body>

<div class="sidebar">
  <h3>Dashboard</h3>
  <a href="http://localhost/KB%20Blogg/blogg.php">🏠 Overview</a>
  <a href="http://localhost/KB%20Blogg/blog_form.php">➕ Add New Post</a>
  <a href="http://localhost/KB%20Blogg/edupdate.php">📝 All Posts</a>
  <a href="http://localhost/KB%20Blogg/view-post.php">👀 View Posts</a>
  <a href="http://localhost/KB%20Blogg/share.php">📤 Share</a>
  <a href="http://localhost/KB%20Blogg/logout.php">🔓 Log Out</a>

</div>

<div class="dashboard-content">
  <h2 class="text-center fw-bold mb-4">📝 Edit / Update Post</h2>

  <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="post_Id" value="<?php echo htmlspecialchars($post['post_Id']); ?>">

      <label>Title:</label>
      <input type="text" name="Title" value="<?php echo htmlspecialchars($post['Title']); ?>" required>

      <label>Content:</label>
      <textarea name="Content" required><?php echo htmlspecialchars($post['Content']); ?></textarea>

      <label>Image:</label>
      <input type="file" name="image">
      <?php if (!empty($post['image'])) { ?>
          <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" width="100">
      <?php } ?>

      <label>Description:</label>
      <input type="text" name="Description" value="<?php echo htmlspecialchars($post['Description']); ?>">

      <button type="submit">Update Post</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
