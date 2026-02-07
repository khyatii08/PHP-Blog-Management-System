<?php
session_start();

// -----------------------------
// Session timeout (1 minute inactive)
$inactive = 60; // seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive) {
    session_unset();
    session_destroy();
    header("Location: adminpanel.php"); // Redirect to login
    exit();
}
$_SESSION['last_activity'] = time();

// -----------------------------
// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: adminpanel.php");
    exit();
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Admins</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style1.css">

  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    table { width: 90%; margin: auto; border-collapse: collapse; margin-top: 30px; }
    th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
    th { background-color: #007bff; color: white; }
    h2 { text-align: center; margin-top: 20px; }
    .btn { padding: 8px 15px; border: none; border-radius: 5px; font-size: 14px; color: white; cursor: pointer; text-decoration: none; }
    .delete-btn { background-color: #dc3545; }
    .delete-btn:hover { background-color: #a71d2a; }
    form { display:inline; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="adlogout.php">Logout</a>
      </li>
    </ul>
  </nav>

    <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
          <li class="nav-item">
            <a href="adminpanel.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="manage_post.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>All Post</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="manage_user.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Manage Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="manage_admin.php" class="nav-link active">
              <i class="nav-icon fas fa-user-shield "></i>
              <p>Manage Admin</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="profile.php" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>Settings</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="content-wrapper">
    <h2>Admin Accounts</h2>

    <?php
    // DB config
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'blog_db';

    // Connect to DB
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle delete request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_admin_id'])) {
        $delete_id = intval($_POST['delete_admin_id']);

        $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            echo "<script>alert('Admin deleted successfully!'); window.location.href='manage_admin.php';</script>";
        } else {
            echo "<script>alert('Failed to delete admin.');</script>";
        }
        $stmt->close();
    }

    // Fetch admin data
    $result = $conn->query("SELECT * FROM admin ORDER BY id ASC");

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Admin ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['password']) . "</td>
                    <td>
                        <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this admin?\");'>
                            <input type='hidden' name='delete_admin_id' value='{$row['id']}'>
                            <button type='submit' class='btn delete-btn'> Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No admin accounts found.</p>";
    }

    $conn->close();
    ?>
  </div>
</div>
</body>
</html>
