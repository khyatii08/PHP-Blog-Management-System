<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #8fe0ecff, #faa2d5ff);
      margin: 0;
      padding: 0;
      text-align: center;
    }

    /* Circular logo */
    .logo {
      width: 200px;        /* adjust size */
      height: 200px;       /* keep square for circle */
      margin: 20px auto;   /* center horizontally */
      display: block;
      border-radius: 50%;  /* makes it circular */
      border: 4px solid white; /* optional border */
      box-shadow: 0 4px 10px rgba(0,0,0,0.2); /* optional shadow */
      object-fit: cover;   /* ensures image covers circle */
    }

    /* Cards container */
    .cards-container {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      padding: 20px;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      width: 300px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card h2 {
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #555;
    }

    .icons {
      margin-top: 15px;
    }

    .icons i {
      margin: 0 8px;
      font-size: 20px;
      color: #007bff;
      cursor: pointer;
    }

    a {
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>
  
  <!-- Circular Logo -->
  <img src="" alt="Logo" class="logo">

  <!-- Cards Container -->
  <div class="cards-container">
    
    <a href="ABC.php">
      <div class="card">
        <h2>ABC </h2>
        <p>Hiee! I’m obsessed with blogging and sharing ideas. 
           I love coding, creativity, and building something meaningful that can make a difference.
        </p>
        <div class="icons">
          <i class="fab fa-whatsapp"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-snapchat"></i>
        </div>
      </div>
    </a>

  
    <a href="DEF.php">
      <div class="card">
        <h2>DEF</h2>
        <p>Hey! I’m equally excited about blogging. I enjoy video editing, designing, 
           and collaborating to create a powerful blogging system with fresh ideas.
        </p>
        <div class="icons">
          <i class="fab fa-whatsapp"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-snapchat"></i>
        </div>
      </div>
    </a>
  </div>

</body>
</html>
