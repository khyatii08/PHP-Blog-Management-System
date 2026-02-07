<?php 
session_start();
include 'db_connect.php';

// -----------------------------
// Fetch logged-in user info
// -----------------------------
$userId = $_SESSION['user_Id'] ?? null;

if ($userId) {
    $userQuery = mysqli_query($conn, "SELECT fullname, Username FROM users WHERE user_Id = $userId");
    if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $userRow = mysqli_fetch_assoc($userQuery);
        $username = !empty($userRow['fullname']) ? $userRow['fullname'] : $userRow['Username'];
    } else {
        $username = 'User';
    }
} else {
    header("Location: login.php");
    exit();
}

// -----------------------------
// Fetch dashboard stats
// -----------------------------
$postCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts"))['total'];
$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];

// 🔹 Fetch only the latest 3 posts
$posts = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3");

// -----------------------------
// Greeting message
// -----------------------------
$hour = (int)date('H');
if ($hour < 12) {
  $timeGreeting = "Good morning";
} elseif ($hour < 18) {
  $timeGreeting = "Good afternoon";
} else {
  $timeGreeting = "Good evening";
}

// -----------------------------
// Random motivational quotes
// -----------------------------
$quotes = [
  "Keep pushing forward — your next post could be your best yet!",
  "Creativity is intelligence having fun. Let’s get started!",
  "Every great post starts with a single idea. What’s yours today?",
  "Your audience is waiting. Time to shine!",
  "Consistency is key. Keep up the great work!"
];
$quote = $quotes[array_rand($quotes)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard</title>
<style>
  * { box-sizing: border-box; }
  body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:0; padding:0; background:#f0f2f5; color:#333; }

  /* Sidebar */
  .sidebar {
    position: fixed; top:0; left:0; height:100vh; width:220px;
    background:#1f2a38; padding:1.5rem 1rem; display:flex; flex-direction:column; gap:1rem;
    color:#ecf0f1;
  }
  .sidebar h3 { margin-bottom:2rem; font-weight:600; font-size:1.6rem; text-align:center; letter-spacing:1px; }
  .sidebar a { color:#ecf0f1; text-decoration:none; padding:0.75rem 1rem; border-radius:6px; transition: all 0.2s; }
  .sidebar a:hover, .sidebar a.active { background:#34495e; font-weight:600; }

  /* Main content */
  .main-content { margin-left:220px; padding:2rem 3rem; max-width:1000px; }

  /* Greeting */
  .greeting h1 { margin:0; font-weight:700; font-size:2.4rem; color:#222; }
  .greeting p { margin:0.3rem 0 2rem; font-style:italic; color:#555; }

  /* Stats Panel */
  .stats-panel { display:flex; gap:1.5rem; margin-bottom:2.5rem; flex-wrap:wrap; }

  /* Colored stat cards */
  .stat-box {
    border-radius: 12px;
    flex: 1;
    padding: 1.5rem;
    text-align: center;
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.4s;
  }

  .stat-box:nth-child(1) {
    background: linear-gradient(135deg, #1d8cf8, #3358f4);
  }
  .stat-box:nth-child(2) {
    background: linear-gradient(135deg, #e4ab56ff, #ee0979);
  }

  .stat-box::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
      120deg,
      rgba(255,255,255,0.2) 0%,
      rgba(255,255,255,0.6) 50%,
      rgba(255,255,255,0.2) 100%
    );
    transform: rotate(25deg);
    opacity: 0;
    transition: opacity 0.4s;
  }

  .stat-box:hover::before {
    animation: shine 1.5s linear forwards;
    opacity: 1;
  }

  @keyframes shine {
    from { transform: translateX(-150%) rotate(25deg); }
    to { transform: translateX(150%) rotate(25deg); }
  }

  .stat-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 25px rgba(255,255,255,0.6), 0 6px 20px rgba(0,0,0,0.2);
  }

  .stat-value { font-size:2.8rem; font-weight:700; margin-bottom:0.4rem; }
  .stat-label { font-weight:600; opacity:0.9; }

  /* Table */
  table { width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05); }
  thead { background:#2c3e50; color:#fff; }
  thead th { text-align:left; padding:12px 15px; font-weight:700; font-size:1rem; }
  tbody td { padding:12px 15px; border-top:1px solid #ddd; color:#2c3e50; }
  tbody tr:hover { background:#f9f9f9; }

  /* Buttons */
  .btn {
    text-decoration:none;
    padding:6px 10px;
    border-radius:4px;
    font-size:0.9rem;
    color:white;
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
    display: inline-block;
    user-select: none;
  }
  .btn-primary {
    background:#0d6efd;
    box-shadow: 0 3px 6px rgba(13,110,253,0.4);
  }
  .btn-primary:hover {
    background:#0b5ed7;
    box-shadow: 0 6px 12px rgba(11,94,215,0.7);
    transform: scale(1.07);
  }
  .btn-danger {
    background:#dc3545;
    box-shadow: 0 3px 6px rgba(220,53,69,0.4);
  }
  .btn-danger:hover {
    background:#bb2d3b;
    box-shadow: 0 6px 12px rgba(187,45,59,0.7);
    transform: scale(1.07);
  }

  @media(max-width:768px){
    .sidebar { position:relative; width:100%; height:auto; }
    .main-content { margin-left:0; padding:1.5rem; }
    .stats-panel { flex-direction:column; }
  }
</style>
</head>
<body>

<nav class="sidebar">
  <h3>Dashboard</h3>
 <a href="http://localhost/KB%20Blogg/blogg.php">🏠 Overview</a>
  <a href="http://localhost/KB%20Blogg/blog_form.php">➕ Add New Post</a>
  <a href="http://localhost/KB%20Blogg/edupdate.php">📝 All Posts</a>
  <a href="http://localhost/KB%20Blogg/view-post.php">👀 View Posts</a>
  <a href="http://localhost/KB%20Blogg/share.php">📤 Share</a>
  <a href="http://localhost/KB%20Blogg/logout.php">🔓 Log Out</a>

</nav>

<main class="main-content">
  <section class="greeting">
    <h1><?= htmlspecialchars($timeGreeting) ?>, <?= htmlspecialchars($username) ?>!</h1>
    <p><?= htmlspecialchars($quote) ?></p>
  </section>

  <section class="stats-panel">
    <div class="stat-box" title="Total number of posts created">
      <div class="stat-value"><?= $postCount ?></div>
      <div class="stat-label">Posts</div>
    </div>
    <div class="stat-box" title="Total registered users">
      <div class="stat-value"><?= $userCount ?></div>
      <div class="stat-label">Users</div>
    </div>
  </section>

  <section class="recent-posts">
    <h2 style="margin-bottom:1rem;">📰 Recent Posts (Last 3)</h2>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if(mysqli_num_rows($posts) === 0): ?>
          <tr><td colspan="3" style="text-align:center; color:#777;">No posts found.</td></tr>
        <?php else: ?>
          <?php while ($row = mysqli_fetch_assoc($posts)): ?>
            <tr>
              <td><?= htmlspecialchars($row['Title'] ?? $row['title'] ?? 'Untitled') ?></td>
              <td><?= isset($row['created_at']) ? date('F j, Y', strtotime($row['created_at'])) : '-' ?></td>
              <td>
                <a href="edupdate.php?post_Id=<?= $row['post_Id'] ?>" class="btn btn-primary">✏️ Edit</a>
                <a href="edupdate.php?post_Id=<?= $row['post_Id'] ?>" class="btn btn-danger">🗑️ Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </section>
</main>

</body>
</html>
