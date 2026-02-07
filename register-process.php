<?php
session_start();
include 'db_connect.php'; // make sure $conn is available

if (isset($_POST['register'])) {

    $fullname = trim($_POST['fullname'] ?? '');
    $Username = trim($_POST['Username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (fullname, Username, email, password, created_at) VALUES (?,?,?,?,NOW())");
    $stmt->bind_param("ssss", $fullname, $Username, $email, $hashed_password);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Show styled success box and redirect to login.php
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Registration Successful</title>
          <style>
            body {
              font-family: Arial, sans-serif;
              background: #f5f5f5;
              display: flex;
              align-items: center;
              justify-content: center;
              height: 100vh;
              margin: 0;
            }
            .box {
              background: #fff;
              padding: 30px;
              border-radius: 10px;
              box-shadow: 0 4px 12px rgba(0,0,0,0.1);
              text-align: center;
              max-width: 400px;
            }
            h1 {
              color: #28a745;
              margin-bottom: 10px;
            }
            p {
              margin-bottom: 20px;
            }
            a {
              display: inline-block;
              padding: 10px 20px;
              background: #007bff;
              color: white;
              border-radius: 5px;
              text-decoration: none;
            }
            a:hover {
              background: #0056b3;
            }
          </style>
        </head>
        <body>
          <div class="box">
            <h1>✅ Registration Successfully!</h1>
            <p>Thank You for choosing us.<br>Redirecting to login page...</p>
            <a href="login.php">Login Now</a>
          </div>
          <script>
            setTimeout(function(){
              window.location.href = "login.php";
            }, 3000); // redirect after 3 seconds
          </script>
        </body>
        </html>
        <?php
        exit(); // Stop PHP execution after showing the page
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
