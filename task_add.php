<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("
    INSERT INTO tasks (name, task_type, description, result_table, has_nodes, has_devices)
    VALUES (?, ?, ?, ?, ?, ?)
  ");
  $stmt->execute([
    $_POST['name'],
    $_POST['task_type'],
    $_POST['description'],
    $_POST['result_table'],
    isset($_POST['has_nodes']) ? 1 : 0,
    isset($_POST['has_devices']) ? 1 : 0
  ]);

  header('Location: tasks.php');
  exit;
}

include 'templates/header.php';
?>

<h4>Добавить задачу</h4>

<form method="post">
  <div class="mb-3"><label class="form-label">Название *</label><input type="text" name="name" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Тип задачи</label><input type="text" name="task_type" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Описание</label><input type="text" name="description" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Таблица результатов</label><input type="text" name="result_table" class="form-control"></div>
  <div class="form-check mb-2">
    <input class="form-check-input" type="checkbox" name="has_nodes" id="has_nodes">
    <label class="form-check-label" for="has_nodes">Задействует узлы</label>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="has_devices" id="has_devices">
    <label class="form-check-label" for="has_devices">Задействует устройства</label>
  </div>
  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<?php include 'templates/footer.php'; ?>
