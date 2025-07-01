<?php
// Selalu mulai session di awal
session_start();

// Cek jika tombol 'tambah_ke_keranjang' ditekan
if (isset($_POST['tambah_ke_keranjang'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Cek apakah produk sudah ada di keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        // Jika sudah ada, tambahkan jumlahnya
        $_SESSION['keranjang'][$id_produk] += $jumlah;
    } else {
        // Jika belum ada, tambahkan sebagai item baru
        $_SESSION['keranjang'][$id_produk] = $jumlah;
    }

    // Redirect ke halaman keranjang untuk melihat hasilnya
    header('Location: keranjang.php');
    exit();
} else {
    // Jika diakses tanpa menekan tombol, kembalikan ke halaman utama
    header('Location: index.php');
    exit();
}
?>