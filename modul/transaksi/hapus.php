<?php
$id = (int)($_GET['id'] ?? 0);

if ($id) {
    hapus_transaksi($id);
    echo '
        <div class="alert alert-success">
            Transaksi berhasil dihapus. 
            <a href="dashboard.php?modul=transaksi&aksi=tampil" class="alert-link">Kembali</a>
        </div>
    ';
} else {
    echo '
        <div class="alert alert-danger">
            ID tidak valid.
        </div>
    ';
}
?>
