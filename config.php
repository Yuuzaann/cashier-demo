<?php
// config.php - sesuaikan kredensial DB jika perlu
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kasir";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8mb4");
?>