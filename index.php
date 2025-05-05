<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header('Location: login.php');
  exit;
}

require_once 'db.php';

function getStatus() {
  return rand(0, 1) ? 'Online' : 'Offline';
}

// Получаем узлы
try {
  $nodes = $pdo->query("SELECT * FROM nodes")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $nodes = [];
}

$onlineCount = 0;
foreach ($nodes as $n) {
  if (getStatus() === 'Online') $onlineCount++;
}

include 'templates/header.php';
?>

<h3>Обзор</h3>

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header bg-light"><b>Узлы</b></div>
      <div class="card-body p-0">
        <table class="table table-striped m-0">
          <thead class="table-dark">
            <tr>
              <th>Имя</th>
              <th>IP</th>
              <th>Местоположение</th>
              <th>Устройство</th>
              <th>Статус</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($nodes as $node): ?>
              <?php
                $status = getStatus();
                $color = $status === 'Online' ? 'success' : 'secondary';
              ?>
              <tr>
                <td><?= htmlspecialchars($node['hostname']) ?></td>
                <td><?= htmlspecialchars($node['ip']) ?></td>
                <td><?= htmlspecialchars($node['location']) ?></td>
                <td><?= htmlspecialchars($node['device']) ?></td>
                <td><span class="badge bg-<?= $color ?>"><?= $status === 'Online' ? 'В сети' : 'Оффлайн' ?></span></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card mb-3">
      <div class="card-header bg-light"><b>📈 Сводка</b></div>
      <div class="card-body">
        <p><b>Диск:</b></p>
        <div class="progress mb-2">
          <div class="progress-bar bg-success" style="width: 44%;">Свободно: 7.77 GB</div>
          <div class="progress-bar bg-warning" style="width: 56%;">Занято: 9.92 GB</div>
        </div>
        <ul class="list-unstyled">
          <li><b>Узлов:</b> <?= count($nodes) ?></li>
          <li><b>Резервных копий:</b> 0</li>
          <li><b>Не назначены:</b> 0</li>
          <li><b>Последнее сканирование:</b> —</li>
          <li><b>Последний бэкап:</b> —</li>
        </ul>
      </div>
    </div>

    <div class="card text-bg-success">
      <div class="card-header"><b>🟢 Узлы в сети</b></div>
      <div class="card-body">
        <h5 class="card-title"><?= $onlineCount ?> узлов онлайн</h5>
        <p class="card-text">Система работает стабильно.</p>
      </div>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>
