<?php
session_start();
include 'inc/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$modul = $_GET['modul'] ?? '';
$aksi  = $_GET['aksi'] ?? 'tampil';

// Menu sederhana
$menu_items = [
    "dashboard" => "bi-speedometer2",
    "produk"    => "bi-box-seam",
    "pelanggan" => "bi-people",
    "transaksi" => "bi-cart-check"
];
if ($_SESSION['user']['role'] === 'admin') {
    $menu_items["user"]    = "bi-person-gear";
    $menu_items["laporan"] = "bi-file-earmark-text";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
@media print {
    .no-print { display: none !important; }
    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #000; }
    th, td { padding: 8px; text-align: left; }
}
#main-content { flex-grow:1; }

/* Fade-in + slide-up animation */
.animate-welcome {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeSlideIn 0.8s forwards;
}

.animate-welcome:nth-child(2) {
  animation-delay: 0.3s; /* paragraf muncul setelah heading */
}

@keyframes fadeSlideIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
  </style>
</head>
<body>

<!-- Navbar Mobile -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top d-lg-none no-print">
  <div class="container-fluid">
    <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
      <i class="bi bi-list"></i>
    </button>
    <span class="navbar-brand ms-2">KasirApps</span>
    <a href="logout.php" class="btn btn-danger btn-sm ms-auto">Logout</a>
  </div>
</nav>

<div class="d-flex">

  <!-- Sidebar Desktop -->
  <nav class="bg-dark text-white p-3 d-none d-lg-flex flex-column vh-100 no-print" style="width:240px;">
    <a href="dashboard.php" class="text-white text-decoration-none d-block mb-3 fs-4 fw-bold">
      <i class="bi-cash-coin me-2"></i>KasirApps
    </a>
    <ul class="nav flex-column flex-grow-1">
      <?php foreach ($menu_items as $key => $icon): ?>
      <li class="nav-item mb-1">
        <a class="nav-link text-white <?= ($modul === $key || ($key === "dashboard" && $modul === "")) ? 'active' : '' ?>"
           href="dashboard.php<?= $key !== 'dashboard' ? '?modul='.$key.'&aksi=tampil' : '' ?>">
          <i class="bi <?= $icon ?>"></i> <?= ucfirst($key) ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="mt-auto">
      <a href="logout.php" class="btn btn-danger w-100">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </nav>

  <!-- Sidebar Mobile Offcanvas -->
  <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">KasirApps</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <?php foreach ($menu_items as $key => $icon): ?>
        <li class="nav-item mb-2">
          <a class="nav-link text-white <?= ($modul === $key || ($key === "dashboard" && $modul === "")) ? 'active' : '' ?>"
             href="dashboard.php<?= $key !== 'dashboard' ? '?modul='.$key.'&aksi=tampil' : '' ?>">
            <i class="bi <?= $icon ?>"></i> <?= ucfirst($key) ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div id="main-content" class="p-3 p-lg-4 flex-grow-1">
    <h3><?= $modul ? ucfirst($modul) : 'Dashboard' ?></h3>
    <div class="card mt-3">
      <div class="card-body">
        <?php
        if ($modul) {
            $path = __DIR__ . '/modul/' . basename($modul) . '/' . basename($aksi) . '.php';
            if (file_exists($path)) {
                include $path;
            } else {
                echo '<div class="alert alert-danger">File modul tidak ditemukan: ' 
                   . htmlspecialchars($path) . '</div>';
            }
        } else {
            // Animasi fade-in + slide-up
            echo '<h5 class="animate-welcome">Selamat datang, ' . htmlspecialchars($_SESSION['user']['username']) . '</h5>';
            echo '<p class="animate-welcome">Gunakan sidebar untuk mengelola data.</p>';
        }
        ?>
      </div>
    </div>
  </div>

</div>
<script src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
