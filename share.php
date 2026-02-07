<?php
session_start();

// CHECK IF USER IS LOGGED IN
if (!isset($_SESSION['user_Id'])) {
    // Redirect to login page if session not found
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Share Post - Blog System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #c3bae9, #e0c3fc);
    }

    /* Sidebar (matches view-post.php) */
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

    .sidebar a:hover,
    .sidebar a.active {
      background: #34495e;
      font-weight: 600;
    }

    /* Main content */
    .dashboard-content {
      margin-left: 220px;
      padding: 2rem;
      min-height: 100vh;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }

      .dashboard-content {
        margin-left: 0;
      }
    }

    /* Share box */
    .share-box {
      margin-top: 30px;
      padding: 25px;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .share-box h4 {
      margin-bottom: 15px;
      color: #2c3e50;
    }

    .share-buttons {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .share-buttons a, .share-buttons button {
      padding: 10px 14px;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      color: white;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: transform 0.2s;
    }

    .share-buttons a:hover, .share-buttons button:hover {
      transform: scale(1.05);
    }

    .share-facebook { background-color: #3b5998; }
    .share-twitter { background-color: #1da1f2; }
    .share-whatsapp { background-color: #25d366; }
    .share-instagram { background-color: #e1306c; }
    .share-snapchat { background-color: #fffc00; color: black; }
    .share-copy { background-color: #6c757d; }

    .share-copy.copied {
      background-color: #28a745;
    }
  </style>
</head>
<body>

  <!-- Sidebar (copied structure from view-post.php) -->
  <div class="sidebar">
    <h3>Dashboard</h3>
    <a href="http://localhost/KB%20Blogg/blogg.php">🏠 Overview</a>
  <a href="http://localhost/KB%20Blogg/blog_form.php">➕ Add New Post</a>
  <a href="http://localhost/KB%20Blogg/edupdate.php">📝 All Posts</a>
  <a href="http://localhost/KB%20Blogg/view-post.php">👀 View Posts</a>
  <a href="http://localhost/KB%20Blogg/share.php">📤 Share</a>
  <a href="http://localhost/KB%20Blogg/logout.php">🔓 Log Out</a>

  </div>

  <!-- Main content -->
  <div class="dashboard-content">
    <div class="share-box">
      <h4><i class="fas fa-share-alt"></i> Share this post:</h4>
      <div class="share-buttons">
        <a class="share-facebook" href="#" target="_blank">
          <i class="fab fa-facebook-f"></i> Facebook
        </a>
        <a class="share-twitter" href="#" target="_blank">
          <i class="fab fa-twitter"></i> Twitter
        </a>
        <a class="share-whatsapp" href="#" target="_blank">
          <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <a class="share-instagram" href="#" target="_blank">
          <i class="fab fa-instagram"></i> Instagram
        </a>
        <a class="share-snapchat" href="#" target="_blank">
          <i class="fab fa-snapchat-ghost"></i> Snapchat
        </a>
        <button class="share-copy" id="copyLinkBtn">
          <i class="fas fa-link"></i> Copy Link
        </button>
      </div>
    </div>
  </div>

  <script>
    const postURL = window.location.href;
    const postTitle = document.title;

    document.querySelector('.share-facebook').href =
      `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postURL)}`;
    document.querySelector('.share-twitter').href =
      `https://twitter.com/intent/tweet?url=${encodeURIComponent(postURL)}&text=${encodeURIComponent(postTitle)}`;
    document.querySelector('.share-whatsapp').href =
      `https://api.whatsapp.com/send?text=${encodeURIComponent(postTitle + ' ' + postURL)}`;
    document.querySelector('.share-instagram').href = `https://www.instagram.com/`;
    document.querySelector('.share-snapchat').href = `https://www.snapchat.com/`;

    const copyBtn = document.getElementById("copyLinkBtn");
    copyBtn.addEventListener("click", function () {
      navigator.clipboard.writeText(postURL).then(() => {
        copyBtn.textContent = "Copied!";
        copyBtn.classList.add("copied");
        setTimeout(() => {
          copyBtn.textContent = "Copy Link";
          copyBtn.classList.remove("copied");
        }, 2000);
      });
    });
  </script>

</body>
</html>