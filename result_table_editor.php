<?php
session_start();
require_once 'db.php';

$add_for_task = $_GET['add_for_task'] ?? null;
$table = $_GET['table'] ?? ($_POST['table'] ?? null);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $columns = array_filter($_POST['columns'] ?? [], fn($c) => preg_match('/^[a-zA-Z0-9_]+$/', $c));
  if (count($columns)) {
    $sql = "CREATE TABLE IF NOT EXISTS `$table` (
      id INT AUTO_INCREMENT PRIMARY KEY,
      " . implode(", ", array_map(fn($c) => "`$c` TEXT", $columns)) . "
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
    
    $pdo->exec($sql);

    if ($add_for_task) {
      $stmt = $pdo->prepare("INSERT INTO task_tables (task_id, table_name) VALUES (?, ?)");
      $stmt->execute([$add_for_task, $table]);
    }

    header("Location: tasks.php?created=$table");
    exit;
  }
}

include 'templates/header.php';
?>

<h4>⚙️ Добавить новую таблицу: <code><?= htmlspecialchars($table) ?></code></h4>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Имя таблицы *</label>
    <input type="text" name="table" class="form-control" required pattern="[a-zA-Z0-9_]+" placeholder="out_backup_cisco">
  </div>

  <div id="column-list">
    <div class="input-group mb-2">
      <input type="text" name="columns[]" class="form-control" placeholder="column_1" required>
      <button class="btn btn-danger" onclick="this.closest('.input-group').remove(); return false;">✖</button>
    </div>
  </div>

  <button class="btn btn-sm btn-outline-success mb-3" type="button" onclick="addColumn()">➕ Добавить колонку</button>

  <div>
    <a href="tasks.php" class="btn btn-secondary">Отмена</a>
    <button type="submit" class="btn btn-primary">Создать</button>
  </div>
</form>

<script>
function addColumn() {
  const el = document.createElement('div');
  el.className = 'input-group mb-2';
  el.innerHTML = `
    <input type="text" name="columns[]" class="form-control" placeholder="column_X" required>
    <button class="btn btn-danger" onclick="this.closest('.input-group').remove(); return false;">✖</button>
  `;
  document.getElementById('column-list').appendChild(el);
}
</script>

<?php include 'templates/footer.php'; ?>
