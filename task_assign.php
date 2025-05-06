<?php
session_start();
require_once 'db.php';

$task_id = $_GET['task'] ?? null;
if (!$task_id) die("Task ID not given.");

$nodes = $pdo->query("SELECT id, hostname, ip FROM nodes")->fetchAll(PDO::FETCH_ASSOC);
$handlers = $pdo->prepare("SELECT id, name FROM handlers WHERE task_id = ?");
$handlers->execute([$task_id]);
$handlers = $handlers->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $node_id = $_POST['node_id'];
  $handler_id = $_POST['handler_id'];

  $stmt = $pdo->prepare("INSERT INTO task_assignments (task_id, node_id, handler_id) VALUES (?, ?, ?)");
  $stmt->execute([$task_id, $node_id, $handler_id]);

  header("Location: tasks.php");
  exit;
}

include 'templates/header.php';
?>

<h4>📌 Назначить задачу узлу</h4>

<form method="post">
  <div class="mb-3">
    <label>Узел *</label>
    <select name="node_id" class="form-select" required>
      <?php foreach ($nodes as $n): ?>
        <option value="<?= $n['id'] ?>"><?= htmlspecialchars($n['hostname']) ?> (<?= $n['ip'] ?>)</option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Обработчик *</label>
    <select name="handler_id" class="form-select" required>
      <?php foreach ($handlers as $h): ?>
        <option value="<?= $h['id'] ?>"><?= htmlspecialchars($h['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Назначить</button>
  <a href="tasks.php" class="btn btn-secondary">Назад</a>
</form>

<?php include 'templates/footer.php'; ?>
