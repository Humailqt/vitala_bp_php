<?php
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username === 'admin' && $password === 'admin') {
    $_SESSION['logged_in'] = true;
    header('Location: index.php');
    exit;
  } else {
    $error = 'Неверный логин или пароль';
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-header bg-dark text-white text-center">
            <h4>Вход в систему</h4>
          </div>
          <div class="card-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Логин</label>
                <input type="text" name="username" class="form-control" required autofocus>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Войти</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
