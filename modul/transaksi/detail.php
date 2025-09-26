<?php
$id = (int)($_GET['id'] ?? 0);
$t  = get_transaksi_by_id($id);

if (!$t) {
  echo '<div class="alert alert-danger animate-msg">Transaksi tidak ditemukan</div>';
  return;
}
?>

<h5 class="animate-title">Detail Transaksi #<?= $t['id'] ?></h5>
<p class="animate-title">
  <strong>Tanggal:</strong> <?= $t['tanggal'] ?>
</p>

<table class="table table-bordered animate-table">
  <thead>
    <tr>
      <th>Produk</th>
      <th>Harga</th>
      <th>Qty</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($t['items'] as $it): ?>
      <tr class="animate-row">
        <td><?= htmlspecialchars($it['nama']) ?></td>
        <td><?= number_format($it['subtotal'] / $it['qty']) ?></td>
        <td><?= $it['qty'] ?></td>
        <td><?= number_format($it['subtotal']) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr class="animate-row total-row">
      <td colspan="3" class="text-end"><strong>Total</strong></td>
      <td><strong><?= number_format($t['total']) ?></strong></td>
    </tr>
  </tbody>
</table>

<!-- Tombol Cetak -->
<div class="mt-3 mb-3 no-print">
    <button class="btn btn-success" onclick="window.print()">🖨 Cetak Struk</button>
    <a href="dashboard.php?modul=produk&aksi=tampil" class="btn btn-secondary animate-btn">Kembali</a>
</div>

<!-- CSS -->
<style>
/* Tabel fade-in */
.animate-table {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}
.animate-table.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Baris fade-in staggered */
.animate-row {
  opacity: 0;
  transform: translateX(-20px);
  transition: all 0.4s ease;
}
.animate-row.visible {
  opacity: 1;
  transform: translateX(0);
}

/* Highlight baris saat hover */
.animate-row:hover {
  background-color: rgba(13, 110, 253, 0.1);
  transition: background-color 0.3s ease;
}

/* Alert fade-in */
.animate-msg {
  opacity: 0;
  transform: translateY(-10px);
  animation: fadeInMsg 0.5s forwards;
}
@keyframes fadeInMsg {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Judul fade-in */
.animate-title {
  opacity: 0;
  transform: translateY(-10px);
  animation: fadeInTitle 0.5s forwards;
}
@keyframes fadeInTitle {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Total row highlight */
.total-row {
  background-color: #f8f9fa;
  font-weight: bold;
}

/* Print styles */
@media print {
  body * {
    visibility: hidden;
  }
  table, table * {
    visibility: visible;
  }
  table {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    border-collapse: collapse;
  }
  .total-row {
    background-color: #f8f9fa !important;
  }
}
</style>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const table = document.querySelector(".animate-table");
  if(table) table.classList.add("visible");

  const rows = document.querySelectorAll(".animate-row");
  rows.forEach((row, index) => {
    setTimeout(() => row.classList.add("visible"), index * 100);
  });

  const titles = document.querySelectorAll(".animate-title");
  titles.forEach((el, i) => {
    el.style.animationDelay = (i * 0.1) + "s";
  });
});
</script>
