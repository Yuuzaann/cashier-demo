<?php
$id = (int)($_GET['id'] ?? 0);

if ($id) {
    hapus_produk($id);
    echo '<div class="alert alert-success">
            Produk dihapus. 
            <a href="dashboard.php?modul=produk&aksi=tampil">Kembali</a>
          </div>';
} else {
    echo '<div class="alert alert-danger">ID tidak valid</div>';
}
?>
