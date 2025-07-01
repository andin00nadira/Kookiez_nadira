<?php
session_start();
// Sertakan file koneksi
include 'koneksi.php';

// Cek apakah ID produk ada di URL
if (!isset($_GET['id'])) {
    // Jika tidak ada ID, redirect ke halaman produk
    header("Location: produk.php");
    exit();
}

$id_produk = intval($_GET['id']); // Ambil ID dan pastikan itu adalah integer untuk keamanan

// Query untuk mengambil data produk spesifik beserta kategorinya
$query = "SELECT nadira_produk.*, nadira_kategori.nama_kategori 
          FROM nadira_produk 
          JOIN nadira_kategori ON nadira_produk.id_kategori = nadira_kategori.id_kategori
          WHERE nadira_produk.id_produk = $id_produk";

$result = mysqli_query($koneksi, $query);
$produk = mysqli_fetch_assoc($result);

// Jika produk dengan ID tersebut tidak ditemukan
if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produk['nama_produk']); ?> - Kookiez</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        background-color: #FDE2E4;
        color: #4A4A4A;
    }

    .header {
        background-color: #5C4033;
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
        font-size: 1.05em;
    }

    .header nav a:hover {
        text-decoration: underline;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(92, 64, 51, 0.15);
    }

    .product-detail-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: flex-start;
    }

    .product-image-container img {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .product-info h1 {
        font-size: 2.5em;
        margin-top: 0;
        margin-bottom: 10px;
        color: #5C4033;
    }

    .product-info .category {
        font-size: 1.1em;
        color: #8B5E3C;
        margin-bottom: 15px;
    }

    .product-info .price {
        font-size: 2em;
        font-weight: bold;
        color: #A0522D;
        margin-bottom: 20px;
    }

    .product-info .description {
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .add-to-cart-form {
        display: flex;
        align-items: center;
        margin-top: 20px;
    }

    .add-to-cart-form input[type="number"] {
        width: 80px;
        padding: 10px;
        text-align: center;
        margin-right: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .add-to-cart-form button {
        background-color: #7B5E57;
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 1.1em;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart-form button:hover {
        background-color: #5C4033;
    }

    .footer {
        text-align: center;
        padding: 20px;
        margin-top: 40px;
        background-color: #FADADD;
        color: #5C4033;
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
        <div class="product-detail-layout">
            <div class="product-image-container">
                <img src="gambar/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>">
            </div>
            <div class="product-info">
                <div class="category"><?php echo htmlspecialchars($produk['nama_kategori']); ?></div>
                <h1><?php echo htmlspecialchars($produk['nama_produk']); ?></h1>
                <div class="price">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                <p class="description"><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
                
                <form action="keranjang_aksi.php" method="post" class="add-to-cart-form">
    <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
    <input type="number" name="jumlah" value="1" min="1" max="<?php echo $produk['stok']; ?>">
    <button type="submit" name="tambah_ke_keranjang">Tambah ke Keranjang</button>
</form>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy;andin</p>
    </footer>

</body>
</html>