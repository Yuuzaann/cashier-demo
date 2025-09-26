<?php
$trs = get_transaksi();
?>

<a href="dashboard.php?modul=transaksi&aksi=tambah" class="btn btn-primary mb-2 animate-btn">
  Buat Transaksi
</a>

<table class="table table-bordered animate-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tanggal</th>
      <th>Pelanggan</th>
      <th>Total</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($trs as $t): ?>
      <tr class="animate-row">
        <td><?= $t['id'] ?></td>
        <td><?= $t['tanggal'] ?></td>
        <td><?= htmlspecialchars($t['pelanggan_nama']) ?></td>
        <td><?= number_format($t['total']) ?></td>
        <td>
          <a 
            class="btn btn-sm btn-info animate-btn" 
            href="dashboard.php?modul=transaksi&aksi=detail&id=<?= $t['id'] ?>"
          >
            Detail
          </a>
          <a 
            class="btn btn-sm btn-danger animate-btn" 
            href="dashboard.php?modul=transaksi&aksi=hapus&id=<?= $t['id'] ?>" 
            onclick="return confirm('Hapus transaksi?')"
          >
            Hapus
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

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

/* Tombol hover + ripple */
.animate-btn {
  position: relative;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.animate-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.animate-btn:after {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  pointer-events: none;
  background: radial-gradient(circle, rgba(255,255,255,0.4) 10%, transparent 10.01%);
  background-repeat: no-repeat;
  background-position: 50%;
  transform: scale(10,10);
  opacity: 0;
  transition: transform 0.5s, opacity 1s;
}
.animate-btn:active:after {
  transform: scale(0,0);
  opacity: 0.3;
  transition: 0s;
}
</style>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const table = document.querySelector(".animate-table");
  if(table) table.classList.add("visible");

  const rows = document.querySelectorAll(".animate-row");
  rows.forEach((row, index) => {
    setTimeout(() => row.classList.add("visible"), index * 100); // staggered effect
  });
});
</script>
