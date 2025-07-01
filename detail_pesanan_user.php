<?php
include 'cek_login.php';
include 'koneksi.php';

$id_pengguna = $_SESSION['user_id'];
$id_pesanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query_pesanan = "SELECT * FROM nadira_pesanan WHERE id_pesanan = '$id_pesanan' AND id_pengguna = '$id_pengguna'";
$result_pesanan = mysqli_query($koneksi, $query_pesanan);

if (mysqli_num_rows($result_pesanan) == 0) {
    echo "Pesanan tidak ditemukan atau Anda tidak memiliki akses.";
    exit();
}
$pesanan = mysqli_fetch_assoc($result_pesanan);

$query_items = "SELECT p.nama_produk, p.gambar, dp.jumlah, dp.harga_satuan 
                FROM nadira_detail_pesanan dp
                JOIN nadira_produk p ON dp.id_produk = p.id_produk
                WHERE dp.id_pesanan = '$id_pesanan'";
$result_items = mysqli_query($koneksi, $query_items);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan-Kookiez</title>
    <style>
        /* Palet Warna "Earthy & Natural" */
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
        .order-meta { background-color: var(--white-pure); border: 1px solid var(--border-warm); padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .button-secondary { display: inline-block; padding: 10px 20px; background-color: #BDBDBD; color: var(--text-deep-brown); border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .button-secondary:hover { background-color: #9E9E9E; color: var(--text-deep-brown); }
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
        <h1 class="page-title">Detail Pesanan</h1>
        
        <div class="order-meta">
            <p><strong>Tanggal:</strong> <?php echo date('d M Y, H:i', strtotime($pesanan['tanggal_pesanan'])); ?></p>
            <p><strong>Total:</strong> Rp <?php echo number_format($pesanan['total_harga']); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($pesanan['status_pesanan']); ?></p>
        </div>

        <h3>Item yang Dipesan:</h3>
        <table class="styled-table">
            <thead>
                <tr>
                    <th colspan="2">Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result_items)): ?>
                <tr>
                    <td style="width: 80px;"><img src="gambar/<?php echo $item['gambar']; ?>" width="60" alt="<?php echo htmlspecialchars($item['nama_produk']); ?>"></td>
                    <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                    <td><?php echo $item['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($item['harga_satuan']); ?></td>
                    <td>Rp <?php echo number_format($item['jumlah'] * $item['harga_satuan']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <a href="riwayat_pesanan.php" class="button-secondary">← Kembali ke Riwayat Pesanan</a>
    </div>

    <footer class="footer">
        <p>&copy; andin</p>
    </footer>

</body>
</html>