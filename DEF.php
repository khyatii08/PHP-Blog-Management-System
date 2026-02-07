<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DEF -Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #89f7fe, #66a6ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .profile-card {
      background: white;
      border-radius: 12px;
      padding: 40px;
      width: 450px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .profile-card img {
      width: 250px;   /* Bigger photo */
      height: 250px;
      border-radius: 50%; /* keep it circular */
      object-fit: cover;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .profile-card h2 {
      margin: 10px 0;
      font-size: 26px;
    }
    .info {
      text-align: left;
      margin-top: 20px;
      font-size: 16px;
    }
    .info p {
      margin: 8px 0;
    }
    .social {
      margin-top: 20px;
    }
    .social i {
      margin: 0 10px;
      font-size: 24px;
      color: #007bff;
      cursor: pointer;
    }
    a.back {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    a.back:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="profile-card">
    <img src="" alt="Profile Photo"> 
    <h2>DEF</h2>
    <p>💻 Digital Journaling | 🎨 Creative Designer | 🎥 Video Editor</p>
    <div class="info">
      <p><strong>Email:</strong> bansichavda01@gmail.com</p>
      <p><strong>Phone:</strong> +91 8469107198</p>
      <p><strong>Location:</strong> Rajkot, India</p>
    </div>

    <a href="profile.php" class="back">← Back</a>
  </div>
</body>
</html>



