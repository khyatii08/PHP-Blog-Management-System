<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <!-- Your custom CSS -->
  <link rel="stylesheet" href="style2.css">

  <style>
    /* === Button Hover Effect === */
    .btn-primary {
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3; /* darker blue on hover */
      transform: scale(1.05); /* small zoom */
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* soft glow */
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="logo.html">
        <img src="Images/OUR.png" alt="Logo" width="60" height="60" class="me-2">
        <span>OurBlog</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
          <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
          <li class="nav-item"><a class="nav-link" href="adminlogin.php">Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Section -->
  <section class="container my-5">
    <div class="row g-4">
      <div class="col-md-6 text-center">
        <img src="Images/blog.png" class="img-fluid mb-3" alt="Image 1">
        <p>Your blog is hosted on a modern, secure cloud platform - always ready for your next post.</p>
        <a href="signup.php" class="btn btn-primary">✍ Start Blogging</a>
      </div>

      <div class="col-md-6 text-center">
        <img src="Images/tablet-which-you-can-read-blog.jpg" class="img-fluid mb-3" alt="Image 2">
        <p>Start your blogging journey today. Create, publish and connect - it's that simple.</p>
        <a href="signup.php" class="btn btn-primary">🔍 Browse More</a>
      </div>

      <div class="col-md-6 text-center">
        <img src="Images/blog_17653850.png" class="img-fluid mb-3" alt="Image 3">
        <p>Share your thoughts, ideas, and experiences with the world.</p>
        <a href="signup.php" class="btn btn-primary">👥 Join Now</a>
      </div>

      <div class="col-md-6 text-center">
        <img src="Images/news-report_5395617.png" class="img-fluid mb-3" alt="Image 4">
        <p>Our blog is a space for curious minds, creative thinkers and lifelong learners.</p>
        <a href="about.php" class="btn btn-primary">📝 Start Your Journey With Us</a>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
