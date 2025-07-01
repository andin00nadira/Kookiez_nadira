<?php
session_start();
// Sertakan file koneksi untuk menghubungkan ke database
include 'koneksi.php';


// Query untuk mengambil beberapa produk terbaru sebagai produk unggulan (misalnya 8 produk)
$query = "SELECT nadira_produk.*, nadira_kategori.nama_kategori 
          FROM nadira_produk 
          JOIN nadira_kategori ON nadira_produk.id_kategori = nadira_kategori.id_kategori
          ORDER BY nadira_produk.id_produk DESC
          LIMIT 8";

$result = mysqli_query($koneksi, $query);

// Cek jika query gagal
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kookiez - Cookies Lezat Buatan Rumah</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #FDE2E4;
            color: #333;
        }
        .header {
            background-color: #5C4033; /* Warna cokelat kayu */
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header .logo {
            font-size: 1.8em;
            font-weight: bold;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.1em;
        }
        .container {
            padding: 20px 40px;
        }
        .hero {
            text-align: center;
            padding: 40px 20px;
            background-color: #FFF8E1;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .hero h1 {
            font-size: 2.5em;
            color: #5D4037;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }
        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-card-content {
            padding: 15px;
        }
        .product-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.2em;
        }
        .product-card .category {
            font-size: 0.9em;
            color: #888;
            margin-bottom: 10px;
        }
        .product-card .price {
            font-size: 1.1em;
            font-weight: bold;
            color: #D2691E;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background-color: #f2f2f2;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo">Kookiez</div>
        <nav>
    <a href="index.php">Beranda</a>
    <a href="produk.php">Produk</a>
    <?php
    // Pastikan session sudah dimulai di bagian paling atas file
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
        <section class="hero">
            <h1>Selamat Datang di Kookiez!</h1>
            <p>Temukan kelezatan cookies buatan rumah dengan bahan-bahan premium pilihan.</p>
        </section>

        <h2>Produk Unggulan Kami</h2>
        <div class="product-grid">
            <?php
            // Looping untuk menampilkan setiap produk
            if (mysqli_num_rows($result) > 0) {
                while($produk = mysqli_fetch_assoc($result)) {
            ?>
                <div class="product-card" onclick="window.location.href='detail_produk.php?id=<?php echo $produk['id_produk']; ?>'">
                    <img src="gambar/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>">
                    <div class="product-card-content">
                        <div class="category"><?php echo htmlspecialchars($produk['nama_kategori']); ?></div>
                        <h3><?php echo htmlspecialchars($produk['nama_produk']); ?></h3>
                        <div class="price">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>Saat ini belum ada produk unggulan yang tersedia.</p>";
            }
            ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; andin bakery</p>
    </footer>

</body>
</html>