<?php
$id = (int)($_GET['id'] ?? 0);

if ($id) {
    hapus_user($id);
    echo '
        <div class="alert alert-success">
            User berhasil dihapus. 
            <a href="dashboard.php?modul=user&aksi=tampil" class="alert-link">Kembali</a>
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
