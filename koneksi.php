<?php
// Konfigurasi untuk koneksi ke database
$host           = "localhost";      // Nama server database (biasanya "localhost")
$user           = "root";           // Username database (default XAMPP adalah "root")
$password       = "";               // Password database (default XAMPP kosong)
$databaseName   = "db_kookiez";     // Nama database yang sudah kita buat

// Membuat koneksi ke database menggunakan MySQLi
$koneksi = mysqli_connect($host, $user, $password, $databaseName);

// Pengecekan koneksi
// Jika koneksi gagal, hentikan script dan tampilkan pesan error
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Jika koneksi berhasil, script akan lanjut berjalan tanpa menampilkan apa pun.
// Kita bisa biarkan seperti ini atau menambahkan pesan sukses untuk pengetesan awal.
// echo "Koneksi ke database berhasil!"; 
?>