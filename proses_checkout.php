<?php
session_start();
include 'koneksi.php';

// Validasi dasar
if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_SESSION['keranjang'])) {
    header('Location: index.php');
    exit();
}

// Ambil data dari form
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$total_harga = $_POST['total_harga'];

// Inisialisasi variabel untuk ID pengguna
$id_pengguna = null;

// Mulai transaksi
mysqli_begin_transaction($koneksi);

try {
    // =================================================================
    // BAGIAN LOGIKA PENGGUNA YANG DIPERBARUI
    // =================================================================

    // 1. Cek dulu apakah pengguna sedang login
    if (isset($_SESSION['user_id'])) {
        $id_pengguna = $_SESSION['user_id'];
    } else {
        // 2. Jika tidak login (tamu), cek apakah email sudah ada di database
        $query_cek_email = "SELECT id_pengguna FROM nadira_pengguna WHERE email = '$email'";
        $result_cek_email = mysqli_query($koneksi, $query_cek_email);

        if (mysqli_num_rows($result_cek_email) > 0) {
            // Jika email sudah ada, gunakan ID pengguna yang ada
            $data_pengguna = mysqli_fetch_assoc($result_cek_email);
            $id_pengguna = $data_pengguna['id_pengguna'];
        } else {
            // 3. Jika email belum ada, baru buat pengguna baru
            $password_placeholder = password_hash(rand(), PASSWORD_DEFAULT); // Password acak untuk tamu
            $query_pengguna = "INSERT INTO nadira_pengguna (nama_lengkap, email, password, alamat, peran) VALUES ('$nama', '$email', '$password_placeholder', '$alamat', 'pelanggan')";
            mysqli_query($koneksi, $query_pengguna);
            $id_pengguna = mysqli_insert_id($koneksi); // Ambil ID pengguna yang baru dibuat
        }
    }
    
    // =================================================================
    // AKHIR DARI BAGIAN YANG DIPERBARUI
    // =================================================================


    // 4. Simpan data pesanan menggunakan ID pengguna yang sudah kita dapatkan
    $query_pesanan = "INSERT INTO nadira_pesanan (id_pengguna, total_harga, status_pesanan) VALUES ('$id_pengguna', '$total_harga', 'pending')";
    mysqli_query($koneksi, $query_pesanan);
    $id_pesanan_baru = mysqli_insert_id($koneksi);

    // 5. Simpan setiap item di keranjang ke detail pesanan & kurangi stok
    foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
        $res_produk = mysqli_query($koneksi, "SELECT harga FROM nadira_produk WHERE id_produk=$id_produk");
        $data_produk = mysqli_fetch_assoc($res_produk);
        $harga_satuan = $data_produk['harga'];

        $query_detail = "INSERT INTO nadira_detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan) VALUES ('$id_pesanan_baru', '$id_produk', '$jumlah', '$harga_satuan')";
        mysqli_query($koneksi, $query_detail);

        $query_stok = "UPDATE nadira_produk SET stok = stok - $jumlah WHERE id_produk = $id_produk";
        mysqli_query($koneksi, $query_stok);
    }

    // Jika semua query berhasil, commit transaksi
    mysqli_commit($koneksi);

    // Kosongkan keranjang belanja
    unset($_SESSION['keranjang']);

    // Redirect ke halaman sukses
    header('Location: pesanan_sukses.php?order_id=' . $id_pesanan_baru);
    exit();

} catch (Exception $e) {
    // Jika ada error, rollback semua perubahan
    mysqli_rollback($koneksi);
    // Tampilkan pesan error (dalam development)
    echo "Gagal memproses pesanan: " . $e->getMessage();
}
?>