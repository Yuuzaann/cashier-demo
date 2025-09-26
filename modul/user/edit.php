<?php
$id = (int)($_GET['id'] ?? 0);
$d  = get_user_by_id($id);

if (!$d) {
    echo '<div class="alert alert-danger animate-msg">User tidak ditemukan</div>';
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_user(
        $id,
        $_POST['username'],
        $_POST['password'] ?? '',
        $_POST['role']
    );
    echo '
        <div class="alert alert-success animate-msg">
            Perubahan disimpan. 
            <a href="dashboard.php?modul=user&aksi=tampil" class="alert-link">Kembali</a>
        </div>
    ';
} else {
?>
    <form method="post" class="animate-form">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input 
                name="username" 
                class="form-control animate-input" 
                value="<?= htmlspecialchars($d['username']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Password (kosongkan jika tidak diubah)</label>
            <input 
                name="password" 
                type="password" 
                class="form-control animate-input"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select animate-input">
                <option value="admin" <?= ($d['role'] == 'admin' ? 'selected' : '') ?>>Admin</option>
                <option value="kasir" <?= ($d['role'] == 'kasir' ? 'selected' : '') ?>>Kasir</option>
            </select>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary animate-btn">Simpan</button>
            <a href="dashboard.php?modul=produk&aksi=tampil" class="btn btn-secondary animate-btn">Kembali</a>
        </div>
    </form>
<?php } ?>

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

/* Input & select focus effect */
.animate-input {
  transition: all 0.3s ease;
}
.animate-input:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 5px rgba(13,110,253,0.5);
  outline: none;
}

/* Tombol hover */
.animate-btn {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.animate-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
</style>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".animate-form");
    if(form) form.classList.add("visible");
});
</script>
