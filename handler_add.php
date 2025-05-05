<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO handlers (task_id, name, description) VALUES (?, ?, ?)");
  $stmt->execute([
    $_POST['task_id'],
    $_POST['name'],
    $_POST['description']
  ]);

  header("Location: tasks.php");
  exit;
}

$task_id = $_GET['task'] ?? null;

include 'templates/header.php';
?>

<h4>➕ Добавить обработчик</h4>

<form method="post">
  <input type="hidden" name="task_id" value="<?= htmlspecialchars($task_id) ?>">

  <div class="mb-3">
    <label class="form-label">Название обработчика *</label>
    <input type="text" name="name" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" class="form-control"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<?php include 'templates/footer.php'; ?>
