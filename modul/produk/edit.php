<?php
$id   = (int)($_GET['id'] ?? 0);
$data = get_produk_by_id($id);

if (!$data) {
    echo '<div class="alert alert-danger">Produk tidak ditemukan</div>';
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_produk($id, $_POST['nama'], $_POST['harga'], $_POST['stok']);
    echo '<div class="alert alert-success animate-msg">
            Produk diperbarui. 
            <a href="dashboard.php?modul=produk&aksi=tampil" class="alert-link">Kembali</a>
          </div>';
} else {
?>
    <form method="post" class="animate-form">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input 
                type="text" 
                name="nama" 
                class="form-control animate-input" 
                value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input 
                type="number" 
                name="harga" 
                class="form-control animate-input" 
                value="<?= htmlspecialchars($data['harga']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input 
                type="number" 
                name="stok" 
                class="form-control animate-input" 
                value="<?= htmlspecialchars($data['stok']) ?>" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary animate-btn">Simpan</button>
            <a href="dashboard.php?modul=produk&aksi=tampil" class="btn btn-secondary animate-btn">Kembali</a>
        </div>
    </form>
<?php } ?>

<!-- CSS -->
<style>
.animate-form {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}
.animate-form.visible { opacity: 1; transform: translateY(0); }

.animate-input {
  transition: all 0.3s ease;
}
.animate-input:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 5px rgba(13,110,253,0.5);
  outline: none;
}

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
  top: 0; left: 0;
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

.animate-msg {
  opacity: 0;
  transform: translateY(-10px);
  animation: fadeInMsg 0.5s forwards;
}
@keyframes fadeInMsg {
  to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".animate-form");
    if(form) form.classList.add("visible");
});
</script>
