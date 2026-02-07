<?php 
// Database connection
$conn = new mysqli("localhost", "root", "", "blog_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Blog Posts</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f2f5;
      color: #333;
    }

    /* Sidebar - Dashboard Style */
    .sidebar {
      position: fixed; top:0; left:0; height:100vh; width:220px;
      background:#1f2a38; padding:1.5rem 1rem; display:flex; flex-direction:column; gap:1rem;
      color:#ecf0f1;
    }
    .sidebar h3 {
      margin-bottom:2rem; font-weight:600; font-size:1.6rem; text-align:center; letter-spacing:1px;
    }
    .sidebar a {
      color:#ecf0f1; text-decoration:none; padding:0.75rem 1rem; border-radius:6px; transition: all 0.2s;
    }
    .sidebar a:hover, .sidebar a.active {
      background:#34495e; font-weight:600;
    }

    /* Main content */
    .dashboard-content {
      margin-left:220px; padding:2rem; min-height:100vh;
      background: linear-gradient(135deg, #f9e1f7, #e0c3fc);
    }

    @media(max-width:768px){
      .sidebar { position:relative; width:100%; height:auto; }
      .dashboard-content { margin-left:0; }
    }

    /* Post containers */
    .container {
      max-width: 800px;
      margin: 40px auto;
      background-color: #ffffff;
      color: #2c3e50;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      margin-bottom: 40px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .container:hover { transform: translateY(-5px); box-shadow:0 12px 35px rgba(0,0,0,0.2); }

    .post-title { font-size: 2rem; margin-bottom: 10px; }
    .post-meta { color:#7f8c8d; font-size:0.9rem; margin-bottom:20px; }
    .post-image { max-width:100%; height:auto; border-radius:10px; margin-bottom:20px; display:block; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
    .post-content { font-size:1.1rem; color:#34495e; line-height:1.6; }
    
    /* Description Section */
    .description-section { margin-top:30px; }
    .description-section h3 { margin-bottom:1 0px; color:#2c3e50; }
    .description { background:#f6f0fa; padding:15px; border-radius:8px; margin-bottom:10px; border-left:4px solid #a29bfe; }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h3>Dashboard</h3>
<a href="http://localhost/KB%20Blogg/blogg.php">🏠 Overview</a>
  <a href="http://localhost/KB%20Blogg/blog_form.php">➕ Add New Post</a>
  <a href="http://localhost/KB%20Blogg/edupdate.php">📝 All Posts</a>
  <a href="http://localhost/KB%20Blogg/view-post.php">👀 View Posts</a>
  <a href="http://localhost/KB%20Blogg/share.php">📤 Share</a>
  <a href="http://localhost/KB%20Blogg/logout.php">🔓 Log Out</a></div>

<!-- Main content -->
<div class="dashboard-content">
<?php
if ($result->num_rows > 0):
    while($row = $result->fetch_assoc()):
?>
  <div class="container">
    <h1 class="post-title"><?= htmlspecialchars($row['Title']) ?></h1>
    <div class="post-meta">Published on <em><?= $row['created_at'] ?></em></div>

    <?php if (!empty($row['image'])): ?>
      <?php 
        $imagePath = "uploads/" . $row['image'];
        if (file_exists($imagePath)) {
            echo "<img src='$imagePath' alt='Post Image' class='post-image' />";
        } else {
            echo "<p style='color: red;'>Image not found: $imagePath</p>";
        }
      ?>
    <?php endif; ?>

    <div class="post-content">
      <p><?= nl2br(htmlspecialchars($row['Content'])) ?></p>
    </div>

    <!-- Description Section -->
    <div class="description-section">
      <h3>Description</h3>
      <div class="description">
        <p><?= htmlspecialchars($row['Description']) ?></p>
      </div>
    </div>
  </div>
<?php
    endwhile;
else:
    echo "<div class='container'><h2>No posts found.</h2></div>";
endif;
$conn->close();
?>
</div>

</body>
</html>
