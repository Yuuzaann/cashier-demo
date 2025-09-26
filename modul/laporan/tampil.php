<?php
$from = $_GET['from'] ?? null;
$to   = $_GET['to'] ?? null;
$lap  = get_laporan_penjualan($from, $to);
?>

<!-- Filter Form -->
<form method="get" class="row g-2 mb-3 no-print animate-form">
  <input type="hidden" name="modul" value="laporan">
  <input type="hidden" name="aksi" value="tampil">

  <div class="col-auto">
    <input 
      type="date" 
      name="from" 
      class="form-control animate-input" 
      value="<?= htmlspecialchars($from) ?>"
    >
  </div>

  <div class="col-auto">
    <input 
      type="date" 
      name="to" 
      class="form-control animate-input" 
      value="<?= htmlspecialchars($to) ?>"
    >
  </div>

  <div class="col-auto">
    <button class="btn btn-primary animate-btn">Filter</button>
  </div>
</form>

<!-- Laporan Penjualan -->
<h5>Laporan Penjualan</h5>
<table class="table table-bordered animate-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tanggal</th>
      <th>Pelanggan</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lap as $l): ?>
      <tr class="animate-row">
        <td><?= $l['id'] ?></td>
        <td><?= $l['tanggal'] ?></td>
        <td><?= htmlspecialchars($l['pelanggan']) ?></td>
        <td><?= number_format($l['total']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Stok Produk -->
<h5 class="mt-4">Stok Produk</h5>
<table class="table table-bordered animate-table-stock">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Stok</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach (get_produk() as $p): ?>
      <tr class="animate-row-stock">
        <td><?= htmlspecialchars($p['nama']) ?></td>
        <td><?= $p['stok'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Tombol Cetak -->
<div class="mt-3 d-flex justify-content-center no-print">
    <div class="btn-group">
        <button class="btn btn-success animate-btn" onclick="window.print()">🖨 Cetak Laporan</button>
    </div>
</div>

<!-- CSS -->
<style>
/* Form fade-in */
.animate-form {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}
.animate-form.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Input focus effect */
.animate-input {
  transition: all 0.3s ease;
}
.animate-input:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 5px rgba(13,110,253,0.5);
  outline: none;
}

/* Tabel fade-in */
.animate-table, .animate-table-stock {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}
.animate-table.visible, .animate-table-stock.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Baris fade-in staggered */
.animate-row, .animate-row-stock {
  opacity: 0;
  transform: translateX(-20px);
  transition: all 0.4s ease;
}
.animate-row.visible, .animate-row-stock.visible {
  opacity: 1;
  transform: translateX(0);
}

/* Tombol hover */
.animate-btn {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.animate-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Form
  const form = document.querySelector(".animate-form");
  if(form) form.classList.add("visible");

  // Laporan Penjualan
  const table = document.querySelector(".animate-table");
  if(table) table.classList.add("visible");

  const rows = document.querySelectorAll(".animate-row");
  rows.forEach((row, index) => {
    setTimeout(() => row.classList.add("visible"), index * 100);
  });

  // Stok Produk
  const tableStock = document.querySelector(".animate-table-stock");
  if(tableStock) tableStock.classList.add("visible");

  const rowsStock = document.querySelectorAll(".animate-row-stock");
  rowsStock.forEach((row, index) => {
    setTimeout(() => row.classList.add("visible"), index * 100);
  });
});
</script>
