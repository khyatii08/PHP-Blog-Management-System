<?php
session_start();

// -----------------------------
// Redirect logged-in users to dashboard
// -----------------------------
if (isset($_SESSION['user_Id'])) {
    header("Location: blogg.php");
    exit();
}

// -----------------------------
// Prevent caching
// -----------------------------
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// -----------------------------
// Database connection
// -----------------------------
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'blog_db';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$error = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_Id, Username, password FROM users WHERE Username=? ");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_username, $db_password);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['user'] = $db_username;
                $_SESSION['user_Id'] = $id;
                //header("Location: blog.html");
                header("Location: blogg.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
        $stmt->close();
    } else {
        $error = "Database error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Page</title>
<style>
button:hover { background: #0056b3; }
.error { color: red; text-align: center; margin-bottom: 10px; }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-7 col-sm-9">
      <div class="card shadow p-4">

        <h2 class="text-center mb-4">Login</h2>
        <?php if($error) echo "<div class='error'>$error</div>"; ?>

        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username"
             pattern="^(?=.*[A-Za-z])[A-Za-z0-9]+$"
             title="Username must contain letters and can include numbers (not only numbers)."
             required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="text-center mt-3">Don't have an account? <a href="signup.html">Sign Up</a></p>
      </div>
    </div>
  </div>
</div>

<!-- 🔒 Block browser back/forward -->
<script>
(function(){
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function(){
        window.history.pushState(null, "", window.location.href);
    };
    window.addEventListener("pageshow", function(event){
        if(event.persisted) location.reload();
    });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
