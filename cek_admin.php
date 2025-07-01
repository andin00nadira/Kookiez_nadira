<?php
session_start();

// Cek apakah pengguna sudah login dan apakah perannya adalah 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    // Jika tidak, redirect ke halaman login dengan pesan error
    header("Location: login.php?pesan=Akses Ditolak");
    exit();
}
?>