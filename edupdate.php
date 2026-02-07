<?php 
session_start(); // Start session
if(!isset($_SESSION['user_Id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_Id']; // Current logged-in user

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'blog_db';
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("<p class='no-posts'>Database connection failed: " . $conn->connect_error . "</p>");
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_Id'])) {
    $delete_id = intval($_POST['delete_Id']);
    $stmt = $conn->prepare("DELETE FROM posts WHERE post_Id = ? AND user_Id = ?");
    $stmt->bind_param("ii", $delete_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Post deleted successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('❌ Failed to delete post.');</script>";
    }
    $stmt->close();
}

// Fetch posts only for the logged-in user
$stmt = $conn->prepare("SELECT * FROM posts WHERE user_Id = ? ORDER BY post_Id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit / Update Posts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f0f2f5; color: #333; }
    .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 220px; background: #1f2a38; padding: 1.5rem 1rem; display: flex; flex-direction: column; gap: 1rem; color: #ecf0f1; }
    .sidebar h3 { margin-bottom: 2rem; font-weight: 600; font-size: 1.6rem; text-align: center; letter-spacing: 1px; }
    .sidebar a { color: #ecf0f1; text-decoration: none; padding: 0.75rem 1rem; border-radius: 6px; transition: all 0.2s; }
    .sidebar a:hover, .sidebar a.active { background: #34495e; font-weight: 600; }
    .dashboard-content { margin-left: 220px; padding: 2rem; min-height: 100vh; background: linear-gradient(135deg, #f8f9fa, #dce7ff, #f5e6ff, #e4ffe6); background-size: 300% 300%; animation: gradientShift 10s ease infinite; }
    @keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    @media (max-width: 768px) { .sidebar { position: relative; width: 100%; height: auto; } .dashboard-content { margin-left: 0; } }
    h2 { text-align: center; margin-top: 30px; color: #343a40; font-weight: 700; }
    table { width: 90%; margin: 30px auto; border-collapse: collapse; background: rgba(255,255,255,0.95); border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
    th { background: linear-gradient(90deg, #598fc9ff, #9664ccff); color: white; text-transform: uppercase; }
    tr:hover { background-color: #f1f1f1; transition: 0.3s; }
    img { border-radius: 10px; object-fit: cover; border: 2px solid #f1f1f1; }
    .btn { padding: 8px 15px; border: none; border-radius: 5px; font-size: 14px; color: white; cursor: pointer; text-decoration: none; }
    .edit-btn { background: linear-gradient(90deg, #007BFF, #6a11cb); }
    .edit-btn:hover { opacity: 0.9; }
    .delete-btn { background: linear-gradient(90deg, #dc3545, #ff5f6d); }
    .delete-btn:hover { opacity: 0.9; }
    form { display: inline; }
    p.no-posts { text-align: center; font-size: 18px; margin-top: 50px; color: #555; }
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
  <h2>📝 Edit / Update Posts</h2>

  <?php
  if ($result->num_rows > 0) {
      echo "<table>
              <tr>
                <th>Post ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Description</th>
                <th>Action</th>
              </tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['post_Id']}</td>
                <td>{$row['Title']}</td>
                <td>{$row['Content']}</td>
                <td><img src='uploads/{$row['image']}' height='100px' width='100px'></td>
                <td>{$row['Description']}</td>
                <td>
                  <a class='btn edit-btn' href='edit_action.php?post_Id={$row['post_Id']}'>Edit</a>
                    <input type='hidden' name='delete_Id' value='{$row['post_Id']}'>
                    <button type='submit' class='btn delete-btn'>Delete</button>
                  </form>
                </td>
              </tr>";
      }
      echo "</table>";
  } else {
      echo "<p class='no-posts'>No posts found.</p>";
  }

  $stmt->close();
  $conn->close();
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
