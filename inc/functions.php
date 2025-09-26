<?php
// inc/functions.php - koneksi via config.php
include __DIR__ . '/../config.php';

// ============ AUTH ============
function cek_login($username, $password){
    global $koneksi;
    $u = mysqli_real_escape_string($koneksi, $username);
    $p = md5($password);
    $sql = "SELECT id, username, role FROM users WHERE username='$u' AND password='$p' LIMIT 1";
    return mysqli_fetch_assoc(mysqli_query($koneksi, $sql));
}

// Helper: ambil banyak data
function fetch_all($sql){
    global $koneksi;
    $res = mysqli_query($koneksi, $sql);
    $out=[]; while($r=mysqli_fetch_assoc($res)) $out[]=$r;
    return $out;
}

// ============ PRODUK ============
function get_produk(){ return fetch_all("SELECT * FROM produk ORDER BY id DESC"); }
function get_produk_by_id($id){ global $koneksi; return mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM produk WHERE id=".(int)$id)); }
function tambah_produk($n,$h,$s){ global $koneksi; return mysqli_query($koneksi,"INSERT INTO produk (nama,harga,stok) VALUES ('".mysqli_real_escape_string($koneksi,$n)."',".(float)$h.",".(int)$s.")"); }
function edit_produk($id,$n,$h,$s){ global $koneksi; return mysqli_query($koneksi,"UPDATE produk SET nama='".mysqli_real_escape_string($koneksi,$n)."', harga=".(float)$h.", stok=".(int)$s." WHERE id=".(int)$id); }
function hapus_produk($id){ global $koneksi; return mysqli_query($koneksi,"DELETE FROM produk WHERE id=".(int)$id); }

// ============ PELANGGAN ============
function get_pelanggan(){ return fetch_all("SELECT * FROM pelanggan ORDER BY id DESC"); }
function get_pelanggan_by_id($id){ global $koneksi; return mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM pelanggan WHERE id=".(int)$id)); }
function tambah_pelanggan($n,$a,$t){ global $koneksi; return mysqli_query($koneksi,"INSERT INTO pelanggan (nama,alamat,telp) VALUES ('".mysqli_real_escape_string($koneksi,$n)."','".mysqli_real_escape_string($koneksi,$a)."','".mysqli_real_escape_string($koneksi,$t)."')"); }
function edit_pelanggan($id,$n,$a,$t){ global $koneksi; return mysqli_query($koneksi,"UPDATE pelanggan SET nama='".mysqli_real_escape_string($koneksi,$n)."', alamat='".mysqli_real_escape_string($koneksi,$a)."', telp='".mysqli_real_escape_string($koneksi,$t)."' WHERE id=".(int)$id); }
function hapus_pelanggan($id){ global $koneksi; return mysqli_query($koneksi,"DELETE FROM pelanggan WHERE id=".(int)$id); }

// ============ USER ============
function get_users(){ return fetch_all("SELECT id, username, role FROM users ORDER BY id DESC"); }
function get_user_by_id($id){ global $koneksi; return mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM users WHERE id=".(int)$id)); }
function tambah_user($u,$p,$r){ global $koneksi; return mysqli_query($koneksi,"INSERT INTO users (username,password,role) VALUES ('".mysqli_real_escape_string($koneksi,$u)."','".md5($p)."','".mysqli_real_escape_string($koneksi,$r)."')"); }
function edit_user($id,$u,$p,$r){ global $koneksi; $id=(int)$id; $u=mysqli_real_escape_string($koneksi,$u); $r=mysqli_real_escape_string($koneksi,$r); $set="username='$u', role='$r'"; if($p!=='') $set.=", password='".md5($p)."'"; return mysqli_query($koneksi,"UPDATE users SET $set WHERE id=$id"); }
function hapus_user($id){ global $koneksi; return mysqli_query($koneksi,"DELETE FROM users WHERE id=".(int)$id); }

// ============ TRANSAKSI ============
function tambah_transaksi($pelanggan_id,$items){
    global $koneksi;
    $pel=(int)$pelanggan_id; $total=0;
    foreach($items as $it){ $total += $it['harga']*$it['qty']; }
    mysqli_query($koneksi,"START TRANSACTION");
    if(!mysqli_query($koneksi,"INSERT INTO transaksi (pelanggan_id,total) VALUES ($pel,$total)")) return mysqli_query($koneksi,"ROLLBACK") && false;
    $tid=mysqli_insert_id($koneksi);
    foreach($items as $it){
        $prod=(int)$it['produk_id']; $qty=(int)$it['qty']; $harga=(float)$it['harga']; $sub=$qty*$harga;
        if(!mysqli_query($koneksi,"INSERT INTO transaksi_detail (transaksi_id,produk_id,qty,subtotal) VALUES ($tid,$prod,$qty,$sub)")) return mysqli_query($koneksi,"ROLLBACK") && false;
        mysqli_query($koneksi,"UPDATE produk SET stok=stok-$qty WHERE id=$prod");
    }
    mysqli_query($koneksi,"COMMIT");
    return $tid;
}
function get_transaksi(){ return fetch_all("SELECT t.*,p.nama as pelanggan_nama FROM transaksi t LEFT JOIN pelanggan p ON p.id=t.pelanggan_id ORDER BY t.id DESC"); }
function get_transaksi_by_id($id){
    global $koneksi; $id=(int)$id;
    $t=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM transaksi WHERE id=$id"));
    if($t){ $t['items']=fetch_all("SELECT td.*,pr.nama FROM transaksi_detail td LEFT JOIN produk pr ON pr.id=td.produk_id WHERE td.transaksi_id=$id"); }
    return $t;
}
function hapus_transaksi($id){
    global $koneksi; $id=(int)$id;
    mysqli_query($koneksi,"START TRANSACTION");
    $items=fetch_all("SELECT produk_id,qty FROM transaksi_detail WHERE transaksi_id=$id");
    foreach($items as $it){ mysqli_query($koneksi,"UPDATE produk SET stok=stok+".(int)$it['qty']." WHERE id=".(int)$it['produk_id']); }
    mysqli_query($koneksi,"DELETE FROM transaksi_detail WHERE transaksi_id=$id");
    mysqli_query($koneksi,"DELETE FROM transaksi WHERE id=$id");
    mysqli_query($koneksi,"COMMIT");
    return true;
}

// ============ LAPORAN ============
function get_laporan_penjualan($from=null,$to=null){
    $w=[]; if($from) $w[]="t.tanggal>='".addslashes($from)."'"; if($to) $w[]="t.tanggal<='".addslashes($to)."'";
    $where=$w? 'WHERE '.implode(' AND ',$w):'';
    return fetch_all("SELECT t.id,t.tanggal,t.total,p.nama as pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id=t.pelanggan_id $where ORDER BY t.tanggal DESC");
}
