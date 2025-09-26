<?php
$pelanggan = get_pelanggan();
$produk    = get_produk();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Build items array dari data form
    $items = [];
    foreach ($_POST['produk_id'] as $i => $prod_id) {
        $items[] = [
            'produk_id' => (int) $prod_id,
            'qty'       => (int) $_POST['qty'][$i],
            'harga'     => (float) $_POST['harga'][$i]
        ];
    }

    $id = tambah_transaksi($_POST['pelanggan_id'], $items);

    if ($id) {
        echo '
            <div class="alert alert-success animate-msg">
                Transaksi tersimpan. 
                <a href="dashboard.php?modul=transaksi&aksi=tampil" class="alert-link">Kembali</a>
            </div>
        ';
    } else {
        echo '<div class="alert alert-danger animate-msg">Gagal menyimpan transaksi</div>';
    }
} else {
?>
<form method="post" class="animate-form">
    <!-- Pilih Pelanggan -->
    <div class="mb-3">
        <label class="form-label">Pelanggan</label>
        <select name="pelanggan_id" class="form-select animate-input" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php foreach ($pelanggan as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Item Produk -->
    <div id="items">
        <div class="row g-2 mb-2 item animate-item">
            <div class="col">
                <select name="produk_id[]" class="form-select produk-select animate-input" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php foreach ($produk as $pr): ?>
                        <option value="<?= $pr['id'] ?>" data-harga="<?= $pr['harga'] ?>">
                            <?= htmlspecialchars($pr['nama']) ?> (<?= $pr['stok'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-2">
                <input name="qty[]" type="number" class="form-control animate-input" value="1" min="1" required>
            </div>
            <div class="col-3">
                <input name="harga[]" class="form-control animate-input" readonly>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger btn-sm btn-remove animate-btn">-</button>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <button id="addItem" type="button" class="btn btn-sm btn-secondary animate-btn">
            Tambah Item
        </button>
    </div>

    <div class="d-grid gap-2">
        <button class="btn btn-primary animate-btn">Simpan Transaksi</button>
        <a href="dashboard.php?modul=produk&aksi=tampil" class="btn btn-secondary animate-btn">Kembali</a>
    </div>
</form>

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

/* Item fade-in */
.animate-item {
  opacity: 0;
  transform: translateX(-20px);
  transition: all 0.4s ease;
}
.animate-item.visible {
  opacity: 1;
  transform: translateX(0);
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

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector(".animate-form");
    if(form) form.classList.add("visible");

    const items = document.querySelectorAll('#items .item');
    items.forEach((item, i) => {
        setTimeout(() => item.classList.add('visible'), i * 100);
    });
});

// Tambah / hapus item
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'addItem') {
        const tpl = document.querySelector('#items .item').cloneNode(true);
        tpl.querySelectorAll('input').forEach(i => {
            if (i.type === 'number') i.value = '1';
            else i.value = '';
        });
        tpl.querySelector('select').selectedIndex = 0;
        tpl.classList.remove('visible'); // reset animation
        document.getElementById('items').appendChild(tpl);
        setTimeout(() => tpl.classList.add('visible'), 50); // fade-in
    }

    if (e.target && e.target.classList.contains('btn-remove')) {
        const items = document.querySelectorAll('#items .item');
        if (items.length > 1) {
            e.target.closest('.item').remove();
        }
    }
});

// Update harga otomatis ketika pilih produk
document.addEventListener('change', function(e) {
    if (e.target && e.target.classList.contains('produk-select')) {
        const opt = e.target.selectedOptions[0];
        const harga = opt ? opt.getAttribute('data-harga') : '';
        const hargaInput = e.target.closest('.item').querySelector('input[readonly]');
        if (hargaInput) hargaInput.value = harga;
    }
});
</script>
<?php } ?>
