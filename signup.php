<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign-Up Page</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Your custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-10">
        <div class="card shadow p-4">
          <h2 class="text-center mb-4">Sign-Up</h2>
          
          <form id="signupForm" action="register-process.php" method="POST">
            
            <div class="mb-3">
              <label for="fullname" class="form-label">Fullname:</label>
              <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter your full name" 
              pattern="^[A-Za-z\s]+$" 
             title="Fullname can contain only letters and spaces."
             required>
            </div>

            <div class="mb-3">
              <label for="Username" class="form-label">Username:</label>
              <input type="text" id="Username" name="Username" class="form-control" placeholder="Choose a username" 
              pattern="^(?=.*[A-Za-z])[A-Za-z0-9]+$" 
             title="Username must contain letters and can include numbers (not only numbers)."
             required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">E-mail:</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="yourname@gmail.com" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <input type="hidden" name="register" value="1">
            <button type="submit" class="btn btn-primary w-100">Sign-Up</button>

            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript validation -->
  <script>
    document.getElementById('signupForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value;
      if (!email.endsWith('@gmail.com')) {
        alert('Only Gmail addresses are allowed for registration.');
        e.preventDefault(); // stop form submission
      }
    });
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>