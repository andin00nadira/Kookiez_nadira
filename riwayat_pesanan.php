<?php
include 'cek_login.php'; 
include 'koneksi.php';

$id_pengguna = $_SESSION['user_id'];
$query = "SELECT * FROM nadira_pesanan WHERE id_pengguna = '$id_pengguna' ORDER BY tanggal_pesanan DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Kookiez</title>
    <style>
        :root {
            --brown-wood: #5C4033;
            --pink-terracotta: #E5A384;
            --background-offwhite: #FDE2E4;
            --text-deep-brown: #3E2723;
            --white-pure: #FFFFFF;
            --border-warm: #D7CCC8;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: var(--background-offwhite);
            color: var(--text-deep-brown);
        }
        .container { max-width: 1200px; margin: 40px auto; padding: 20px; }
        h1, h2, h3 { color: var(--text-deep-brown); }
        a { color: var(--brown-wood); text-decoration: none; transition: color 0.2s; }
        a:hover { color: #BCAAA4; }
        .header { background-color: var(--brown-wood); color: var(--white-pure); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo { font-size: 1.8em; font-weight: bold; }
        .header nav a { color: var(--white-pure); margin: 0 15px; font-size: 1.1em; }
        .footer { text-align: center; padding: 20px; margin-top: 40px; background-color: #EFEBE9; color: #6D4C41; border-top: 1px solid var(--border-warm); }
        .page-title { text-align: center; font-size: 2.5em; margin-bottom: 40px; }
        .styled-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 1em; }
        .styled-table thead tr { background-color: #EFEBE9; }
        .styled-table th, .styled-table td { border: 1px solid var(--border-warm); padding: 12px 15px; text-align: left; vertical-align: middle; }
        .styled-table tbody tr:nth-child(even) { background-color: #FBFBFB; }
    </style>
</head>
<body>
    
    <header class="header">
        <div class="logo">Kookiez</div>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="produk.php">Produk</a>
            <?php
            $jumlah_item_keranjang = isset($_SESSION['keranjang']) ? array_sum($_SESSION['keranjang']) : 0;
            ?>
            <a href="keranjang.php">Keranjang (<?php echo $jumlah_item_keranjang; ?>)</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="riwayat_pesanan.php">Riwayat Pesanan</a>
                <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['user_nama']); ?>)</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <h1 class="page-title">Riwayat Pesanan Saya</h1>
        
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($pesanan = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo date('d M Y, H:i', strtotime($pesanan['tanggal_pesanan'])); ?></td>
                        <td>Rp <?php echo number_format($pesanan['total_harga']); ?></td>
                        <td><?php echo ucfirst($pesanan['status_pesanan']); ?></td>
                        <td><a href="detail_pesanan_user.php?id=<?php echo $pesanan['id_pesanan']; ?>">Lihat Detail</a></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 20px;">Anda belum memiliki riwayat pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer class="footer">
        <p>&copy; Andin</p>
    </footer>
    
</body>
</html>