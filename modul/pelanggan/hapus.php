<?php
$id = (int)($_GET['id'] ?? 0);

if ($id) {
    hapus_pelanggan($id);
    echo '<div class="alert alert-success">Pelanggan dihapus. 
            <a href="dashboard.php?modul=pelanggan&aksi=tampil">Kembali</a>
          </div>';
} else {
    echo '<div class="alert alert-danger">ID tidak valid</div>';
}
?>
