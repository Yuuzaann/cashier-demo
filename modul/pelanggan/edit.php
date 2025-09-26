<?php
$id = (int)($_GET['id'] ?? 0);
$d  = get_pelanggan_by_id($id);

if (!$d) {
    echo '<div class="alert alert-danger animate-msg">Pelanggan tidak ditemukan</div>';
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_pelanggan($id, $_POST['nama'], $_POST['alamat'], $_POST['telp']);
    echo '<div class="alert alert-success animate-msg">Perubahan disimpan. 
            <a href="dashboard.php?modul=pelanggan&aksi=tampil">Kembali</a>
          </div>';
} else {
?>
<form method="post" class="animate-form">
  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input name="nama" class="form-control animate-input" value="<?= htmlspecialchars($d['nama']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Telp</label>
    <input name="telp" class="form-control animate-input" value="<?= htmlspecialchars($d['telp']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control animate-input"><?= htmlspecialchars($d['alamat']) ?></textarea>
  </div>
  <div class="d-grid gap-2">
    <button class="btn btn-primary animate-btn">Simpan</button>
    <a href="dashboard.php?modul=produk&aksi=tampil" class="btn btn-secondary animate-btn">Kembali</a>
  </div>
</form>

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

/* Input & textarea focus effect */
.animate-input {
  transition: all 0.3s ease;
}
.animate-input:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 5px rgba(13,110,253,0.5);
  outline: none;
}

/* Button hover + ripple */
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

<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".animate-form");
  if(form) form.classList.add("visible");
});
</script>
<?php } ?>
