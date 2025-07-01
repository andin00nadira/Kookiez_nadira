<?php
session_start();
// Hapus semua variabel session
session_unset();
// Hancurkan session
session_destroy();
// Redirect ke halaman utama
header("Location: index.php");
exit();
?>