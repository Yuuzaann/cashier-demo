<?php
$produk = get_produk();
?>

<a href="dashboard.php?modul=produk&aksi=tambah" class="btn btn-primary mb-2 animate-btn">
  Tambah Produk
</a>

<table class="table table-bordered animate-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($produk as $p): ?>
      <tr class="animate-row">
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['nama']) ?></td>
        <td><?= number_format($p['harga']) ?></td>
        <td><?= $p['stok'] ?></td>
        <td>
          <a href="dashboard.php?modul=produk&aksi=edit&id=<?= $p['id'] ?>" 
             class="btn btn-sm btn-warning animate-btn">
             Edit
          </a>
          <a href="dashboard.php?modul=produk&aksi=hapus&id=<?= $p['id'] ?>" 
             class="btn btn-sm btn-danger animate-btn" 
             onclick="return confirm('Hapus produk ini?')">
             Hapus
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Tambahkan CSS -->
<style>
/* Animasi fade-in untuk tabel */
.animate-table {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}
.animate-table.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Animasi baris */
.animate-row {
  opacity: 0;
  transform: translateX(-20px);
  transition: all 0.4s ease;
}
.animate-row.visible {
  opacity: 1;
  transform: translateX(0);
}

/* Hover effect tombol */
.animate-btn {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.animate-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>

<!-- Tambahkan JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const table = document.querySelector(".animate-table");
  table.classList.add("visible");

  const rows = document.querySelectorAll(".animate-row");
  rows.forEach((row, index) => {
    setTimeout(() => {
      row.classList.add("visible");
    }, index * 100); // efek staggered
  });
});
</script>
