<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Blog Post</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f8f9fa;
    }

    .sidebar {
      position: fixed; 
      top: 0; 
      left: 0; 
      height: 100vh; 
      width: 220px;
      background: #1f2a38; 
      padding: 1.5rem 1rem; 
      display: flex; 
      flex-direction: column; 
      gap: 1rem;
      color: #ecf0f1;
    }

    .sidebar h3 { 
      margin-bottom: 2rem; 
      font-weight: 600; 
      font-size: 1.6rem; 
      text-align: center; 
      letter-spacing: 1px; 
    }

    .sidebar a { 
      color: #ecf0f1; 
      text-decoration: none; 
      padding: 0.75rem 1rem; 
      border-radius: 6px; 
      transition: all 0.2s; 
    }

    .sidebar a:hover, .sidebar a.active { 
      background: #34495e; 
      font-weight: 600; 
    }

    .dashboard-content {
      margin-left: 220px;
      padding: 2rem;
      min-height: 100vh;
      background: linear-gradient(135deg, #f8f9fa, #dce7ff, #f5e6ff, #e4ffe6);
      background-size: 300% 300%;
      animation: gradientShift 10s ease infinite;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @media (max-width: 768px) {
      .sidebar { position: relative; width: 100%; height: auto; }
      .dashboard-content { margin-left: 0; }
    }

    form {
      max-width: 600px;
      margin: 40px auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      backdrop-filter: blur(8px);
    }

    label { font-weight: bold; color: #333; margin-top: 10px; }
    input, textarea, button { width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 6px; }

    button {
      background: linear-gradient(90deg, #007BFF, #6a11cb);
      color: white;
      border: none;
      margin-top: 15px;
      transition: all 0.3s ease;
    }

    button:hover { 
      background: linear-gradient(90deg, #6a11cb, #007BFF);
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px rgba(106, 17, 203, 0.3);
    }
    .success, .error { font-weight: bold; margin-top: 20px; text-align: center; }
    .success { color: green; } 
    .error { color: red; }
  </style>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
  <h3>Dashboard</h3>
  <a href="http://localhost/KB%20Blogg/blogg.php">🏠 Overview</a>
  <a href="http://localhost/KB%20Blogg/blog_form.php" class="active">➕ Add New Post</a>
  <a href="http://localhost/KB%20Blogg/edupdate.php">📝 All Posts</a>
  <a href="http://localhost/KB%20Blogg/view-post.php">👀 View Posts</a>
  <a href="http://localhost/KB%20Blogg/share.php">📤 Share</a>
  <a href="http://localhost/KB%20Blogg/logout.php">🔓 Log Out</a>
</nav>

<!-- Main Content -->
<div class="dashboard-content">
  <h2 class="mb-4 text-center text-dark">Add New Blog Post</h2>

  <form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="action" value="insert">

    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Content:</label>
    <textarea name="content" rows="5" required></textarea>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*">

    <label>Description:</label>
    <textarea name="comments" rows="3" required></textarea>

    <button type="submit" name="submit">Add Post</button>
  </form>

  <?php
  session_start();

  // Redirect if not logged in
  if (!isset($_SESSION['user_Id'])) {
    echo "<p class='error'>⚠️ Please log in first.</p>";
    echo "<script>setTimeout(()=>{window.location.href='login.php';},1500);</script>";
    exit();
  }

  // Database connection
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'blog_db';
  $conn = new mysqli($host, $user, $password, $database);
  if ($conn->connect_error) die("<p class='error'>Database connection failed: " . $conn->connect_error . "</p>");

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'insert') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $comments = trim($_POST['comments'] ?? '');
    $created_at = date('Y-m-d H:i:s');
    $imageName = '';
    $user_Id = $_SESSION['user_Id']; // ✅ logged-in user

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = 'uploads/';
      if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
      $imageName = time() . '_' . basename($_FILES['image']['name']);
      move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
    }

    if ($title === '' || $content === '' || $comments === '') {
      echo "<p class='error'>❌ All fields are required.</p>";
    } else {
      // ✅ Added user_Id in query
      $stmt = $conn->prepare("INSERT INTO posts (user_Id, Title, Content, image, created_at, Description) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssss", $user_Id, $title, $content, $imageName, $created_at, $comments);

      if ($stmt->execute()) {
        echo "<p class='success'>✅ Post added successfully!</p>";
        echo "<script>setTimeout(()=>{window.location.href='addpublish.php';}, 2000);</script>";
      } else {
        echo "<p class='error'>❌ Insert Error: " . htmlspecialchars($stmt->error) . "</p>";
      }
      $stmt->close();
    }
  }
  $conn->close();
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
