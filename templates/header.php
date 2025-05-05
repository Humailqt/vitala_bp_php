<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Система резервирования</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark px-3" style="background: linear-gradient(90deg, #2c2f33, #23272a);">
  <span class="navbar-brand mb-0 h1">Система резервирования</span>
  <span class="text-white">
    <a href="/logout.php" class="text-white text-decoration-none">Выйти</a>
  </span>
</nav>

<div class="d-flex">
  <div class="bg-dark text-white p-3 vh-100" style="width: 220px;">
    <h6 class="text-muted">Меню</h6>
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link text-white" href="index.php">Обзор</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="nodes.php">Узлы</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="tasks.php">Задачи</a></li>
      <li class="nav-item">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#networkMenu" role="button" aria-expanded="true" aria-controls="networkMenu">
          Сети и оборудование ▾
        </a>
        <ul class="nav flex-column collapse show ps-3" id="networkMenu">
          <li class="nav-item"><a class="nav-link text-white" href="subnets.php">Подсети</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="devices.php">Устройства</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="credentials.php">Реквизиты</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="auth_templates.php">Шаблоны аутентификации</a></li>
        </ul>
      </li>
      <li class="nav-item"><a class="nav-link text-white" href="#">Процессы</a></li>
    </ul>
  </div>

  <!-- Контент -->
  <div class="container-fluid mt-4">
