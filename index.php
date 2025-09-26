<?php
// index.php - login
session_start();
include 'inc/functions.php';
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $user = cek_login($u, $p);
    if($user){
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $err = 'Login gagal: username/password salah';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login - Web Kasir</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
      <div class="card login-card">
        <div class="card-body">
          <h4><i class="bi bi-cash-stack me-2 text-primary"></i>Kasir Login</h4>
          <?php if($err): ?>
            <div class="alert alert-danger"><?=htmlspecialchars($err)?></div>
          <?php endif; ?>
          <form method="post" class="position-relative">
            <div class="mb-3 position-relative">
              <span class="input-icon"><i class="bi bi-person"></i></span>
              <input name="username" class="form-control login-input" placeholder="Username" required>
            </div>
            <div class="mb-3 position-relative">
              <span class="input-icon"><i class="bi bi-lock"></i></span>
              <input name="password" type="password" class="form-control login-input" placeholder="Password" required>
            </div>
            <div class="d-grid">
              <button class="btn btn-primary login-btn"><i class="bi bi-box-arrow-in-right me-1"></i> Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script src="assets/js/script.js"></script>
</html>
