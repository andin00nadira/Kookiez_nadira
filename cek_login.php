<?php
// Selalu mulai session di awal
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, redirect ke halaman login dengan pesan
    header("Location: login.php?pesan=Harap login terlebih dahulu");
    exit();
}
?>