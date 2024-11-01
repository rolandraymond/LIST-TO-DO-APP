<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$conn = new mysqli('localhost', 'root', '', 'DP_USERS');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  echo "<p>No user ID found. Please sign in first.</p>";
  exit;
}
$status = 'incomplete';

// Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
  $task = $_POST['task'];
  $stmt = $conn->prepare('INSERT INTO tasks (title, user_id, status) VALUES (?, ?, ?)');
  $stmt->bind_param('sis', $task, $user_id, $status);
  $stmt->execute();
  $stmt->close();
}

// Delete Task
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $conn->prepare('DELETE FROM tasks WHERE id=? AND user_id=?');
  $stmt->bind_param("ii", $id, $user_id);
  $stmt->execute();
  $stmt->close();
}
// Toggle Task Completion Status
if (isset($_GET['complete'])) {
  $id = $_GET['complete'];
  $stmt = $conn->prepare('UPDATE tasks SET status = "complete" WHERE id = ? AND user_id = ?');
  $stmt->bind_param("ii", $id, $user_id);
  $stmt->execute();
  $stmt->close();
}

if (isset($_GET['incomplete'])) {
  $id = $_GET['incomplete'];
  $stmt = $conn->prepare('UPDATE tasks SET status = "incomplete" WHERE id = ? AND user_id = ?');
  $stmt->bind_param("ii", $id, $user_id);
  $stmt->execute();
  $stmt->close();
}
// Fetch Tasks
$result = $conn->prepare("SELECT id, title, status FROM tasks WHERE user_id = ?");
$result->bind_param("i", $user_id);
$result->execute();
$tasks = $result->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="CSS/style_app.css" rel="stylesheet" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Tasks</title>
</head>

<body>

    <div class="container">
        <div class="stats_tasks">
            <div class="details">
                <h1>Let's Do It</h1>
                <div id="progressbar">
                    <div id="progress"></div>
                </div>
            </div>
            <div class="stats_numbers">
                <p id="numbers">0/0</p>
            </div>
        </div>
        <form method="POST" id="taskForm">
            <input type="text" name="task" placeholder="Write your task" />
            <button id="NewTask" type="submit">+</button>
        </form>
        <ul class="tasks_list">
            <?php
      $completedTasks = 0;
      $totalTasks = 0;

      while ($row = $tasks->fetch_assoc()):
        $totalTasks++;
        if ($row['status'] === 'complete') {
          $completedTasks++;
        }
      ?>
            <li>
                <span><?php echo htmlspecialchars($row['title']); ?></span>

                <?php if ($row['status'] === 'complete'): ?>
                <!-- Show "Completed" icon -->
                <a href="?incomplete=<?php echo $row['id']; ?>" class="icon complete">
                    <i class="bx bx-check-circle"></i>
                </a>
                <?php else: ?>
                <!-- Show "Mark as Complete" icon -->
                <a href="?complete=<?php echo $row['id']; ?>" class="icon incomplete">
                    <i class="bx bx-circle"></i>
                </a>
                <?php endif; ?>

                <a href="?delete=<?php echo $row['id']; ?>" class="icon delete">
                    <i class="bx bx-trash"></i>
                </a>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <script>
    // Update progress numbers
    document.getElementById('numbers').textContent = '<?php echo $completedTasks; ?>/<?php echo $totalTasks; ?>';

    // Update progress bar
    const progressBar = document.getElementById('progress');
    const progressPercent = <?php echo ($totalTasks > 0) ? ($completedTasks / $totalTasks) * 100 : 0; ?>;
    progressBar.style.width = progressPercent + '%';
    </script>
</body>

</html>

<?php
$result->close();
$conn->close();
?>