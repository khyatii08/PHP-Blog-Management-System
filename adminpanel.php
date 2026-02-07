<?php
session_start();

// -----------------------------
// Session check
// -----------------------------
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}

// Session timeout (1 minute inactive)
$inactive = 60;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive) {
    session_unset();
    session_destroy();
    header("Location: adminlogin.php");
    exit();
}
$_SESSION['last_activity'] = time();

$adminUsername = $_SESSION['admin'];

// -----------------------------
// Database connection
// -----------------------------
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'blog_db';
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Stats
$postCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts"))['total'];
$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$adminCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM admin"))['total'];
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style1.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
    }
    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      margin-top: 30px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    h2 {
      text-align: center;
      margin-top: 20px;
    }
    .btn {
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      color: white;
      cursor: pointer;
      text-decoration: none;
    }
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
            <a href="adminpanel.php" class="nav-link active">
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
              <i class="nav-icon  fas fa-users"></i>
              <p>Manage Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="manage_admin.php" class="nav-link">
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
    <div class="content-wrapper" style="padding:30px;">
        <h1 class="mb-5">Welcome, <?= htmlspecialchars($adminUsername) ?>!</h1>

        <div class="row">
            <div class="col-lg-4 col-12 mb-4">
                <div class="small-box bg-info text-white">
                    <div class="inner">
                        <h3><?= $postCount ?></h3>
                        <p>Posts</p>
                    </div>
                    <div class="icon"><i class="fas fa-edit"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-12 mb-4">
                <div class="small-box bg-success text-white">
                    <div class="inner">
                        <h3><?= $userCount ?></h3>
                        <p>Users</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-12 mb-4">
                <div class="small-box bg-warning text-white">
                    <div class="inner">
                        <h3><?= $adminCount ?></h3>
                        <p>Admins</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-shield"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
