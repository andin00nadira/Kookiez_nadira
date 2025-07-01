<?php
// Sertakan file koneksi
include 'koneksi.php';

// Cek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // 1. Ambil nama file gambar dari database sebelum menghapus data produk
    $query_select = "SELECT gambar FROM nadira_produk WHERE id_produk = '$id_produk'";
    $result_select = mysqli_query($koneksi, $query_select);
    if ($data = mysqli_fetch_assoc($result_select)) {
        $gambar_lama = $data['gambar'];
        $file_path = 'gambar/' . $gambar_lama;

        // 2. Hapus file gambar dari folder 'gambar/' jika file tersebut ada
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // 3. Buat query untuk menghapus data produk dari database
    $query_delete = "DELETE FROM nadira_produk WHERE id_produk = '$id_produk'";

    // Jalankan query dan cek hasilnya
    if (mysqli_query($koneksi, $query_delete)) {
        // Jika berhasil, redirect kembali ke halaman admin produk
        header("Location: admin_produk.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika tidak ada ID, redirect ke halaman utama admin
    header("Location: admin_produk.php");
    exit();
}
?>