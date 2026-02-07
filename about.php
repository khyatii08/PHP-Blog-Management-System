<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us</title>
  <link rel="stylesheet" href="style3.css" />
  <style>
    /* Left-aligned buttons at the bottom with left spacing */
    .btn-container {
      text-align: left; /* Align left */
      margin-top: 30px; /* Space from content above */
      padding-left: 20px; /* Space from left edge */
    }

    .btn-container a {
      display: inline-block;
      padding: 10px 25px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      color: #fff;
      background-color: #0d6efd; /* Both buttons blue */
      margin-right: 15px; /* Space between buttons */
      transition: all 0.3s ease;
    }

    .btn-container a:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <div class="about-container">
    <section class="intro">
      <h1>About Us</h1>
      <p>Welcome to OurBlog! Your trusted platform for sharing stories, insights & ideas. We believe that everyone has a voice & through blogging, anyone can share their perspective with the world.</p>
      <p>Whether you're a seasoned writer, a passionate hobbyist or someone just getting started, our platform is built to empower creators of all kinds to express themselves freely and meaningfully.</p>
      <p>Who We Are: OurBlog is a modern, user-friendly blog system designed to make publishing content as easy as possible.</p>
      <p>We are a small but dedicated team of developers, writers & creatives who believe in the power of open expression.</p>
    </section>

    <section class="mission">
      <h2>Our Mission</h2>
      <p>Our mission is to provide thoughtful content that educates, entertains & inspires readers around the world.</p>
      <p>Whether it's a deep dive into technology, lifestyle tips, creative writing, we aim to deliver value with every post.</p>
      <p>What We Offer: A clean and intuitive blogging platform, customizable blog themes and layouts. Rich content tools for writing, images, videos & more.</p>
      <p>Community features like comments, likes & follower systems. Tools for SEO, analytics & content management.</p>
      <h2>Our Vision</h2>
      <p>Our goal is to create a vibrant ecosystem where bloggers can grow their audience, connect with others & have full control over their content. We value freedom of expression, creativity & community.</p>
      <p>Whether you're here to start a personal blog, launch a niche publication, follow your favorite writers - you're in the right place.</p>
    </section>

    <section class="team">
      <h2>Join Us</h2>
      <p>Ready to share your voice? Sign up and start your blogging journey today. Let’s write the internet together.</p>
    </section>

    <!-- ✅ Buttons left-aligned with left padding, both blue, with spacing -->
    <div class="btn-container">
      <a href="index.php">⬅ Back to Home</a>
      <a href="signup.php">Sign Up</a>
    </div>

  </div>
</body>
</html>
