<?php
// Sertakan "penjaga" di baris paling atas!
include 'cek_admin.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - Kookiez</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FDE2E4;
            margin: 0;
            padding: 0;
            color: #4A4A4A;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            background: #ffffffcc;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(92, 64, 51, 0.3);
        }
        .header-admin {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-admin h1 {
            color: #8B0000;
            margin: 0;
        }
        .header-admin a {
            text-decoration: none;
            background-color: #D291BC;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: bold;
        }
        .header-admin a:hover {
            background-color: #7B5E57;
        }
        .nav-admin {
            margin-top: 20px;
        }
        .nav-admin a {
            display: block;
            background-color: #5C4033;
            color: white;
            padding: 15px;
            margin-bottom: 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .nav-admin a:hover {
            background-color: #7B5E57;
        }
        h2 {
            color: #8B0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-admin">
            <h1>Selamat Datang, Admin <?php echo htmlspecialchars($_SESSION['user_nama']); ?>!</h1>
            <a href="logout.php">Logout</a>
        </div>
        <hr>
        <h2>Menu Navigasi</h2>
        <div class="nav-admin">
            <a href="admin_produk.php">Manajemen Produk</a>
            <a href="admin_kategori.php">Manajemen Kategori</a>
        </div>
    </div>
</body>
</html>
