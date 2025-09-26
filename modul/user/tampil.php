<?php
$users = get_users();
?>

<a href="dashboard.php?modul=user&aksi=tambah" class="btn btn-primary mb-2 animate-btn">
  Tambah User
</a>

<table class="table table-bordered animate-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Role</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr class="animate-row">
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td>
          <a 
            class="btn btn-sm btn-warning animate-btn" 
            href="dashboard.php?modul=user&aksi=edit&id=<?= $u['id'] ?>"
          >
            Edit
          </a>
          <a 
            class="btn btn-sm btn-danger animate-btn" 
            href="dashboard.php?modul=user&aksi=hapus&id=<?= $u['id'] ?>" 
            onclick="return confirm('Hapus user ini?')"
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
  const table = document.querySelector(".animate-table");
  if(table) table.classList.add("visible");

  const rows = document.querySelectorAll(".animate-row");
  rows.forEach((row, index) => {
    setTimeout(() => {
      row.classList.add("visible");
    }, index * 100); // efek staggered
  });
});
</script>
