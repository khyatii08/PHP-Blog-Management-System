                        <?php 
session_start();

// -----------------------------+
// Session timeout (1 minute inactive)
// -----------------------------
$inactive = 60; // seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive) {
    session_unset();
    session_destroy();
    header("Location: adminpanel.php");
    exit();
}
$_SESSION['last_activity'] = time();

// -----------------------------
// Redirect logged-in users to dashboard
// -----------------------------
if (isset($_SESSION['admin'])) {
    header("Location: adminpanel.php");
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
$host = "localhost";
$dbname = "blog_db";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// -----------------------------
// Handle login form
// -----------------------------
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

        // Prepared statement
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // NOTE: plain text, use hashing in production
    $stmt->execute();
    $result = $stmt->get_result();
-
    if ($result && $result->num_rows === 1) {
        $_SESSION['admin'] = $username;
        $_SESSION['last_activity'] = time();
        header("Location: adminpanel.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="admin.css">
</head

    <body onload="disableBack();" onpageshow="if (event.persisted) disableBack();" onunload="">
    
<div class="login-container">
        <h2>Admin Login</h2>zz
        <form method="POST" action="">
            <label for="username">Username :</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error)) : ?>
            <p class="error" style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

<script>
function disableBack() {
    window.history.forward();
}
(function(){
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function(){
        window.history.pushState(null, "", window.location.href);
    };
})();
</script>

</body>
</html>
