<?php
session_start();
include 'koneksi.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$produk_di_keranjang = [];
$total_harga = 0;

if (!empty($keranjang)) {
    // Ambil semua id produk dari keranjang
    $ids_produk = array_keys($keranjang);
    $ids_string = implode(',', $ids_produk);

    // Query untuk mengambil data semua produk yang ada di keranjang
    $query = "SELECT * FROM nadira_produk WHERE id_produk IN ($ids_string)";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $id_produk = $row['id_produk'];
        $jumlah = $keranjang[$id_produk];
        $subtotal = $row['harga'] * $jumlah;
        $total_harga += $subtotal;

        $produk_di_keranjang[] = [
            'id' => $id_produk,
            'nama' => $row['nama_produk'],
            'harga' => $row['harga'],
            'gambar' => $row['gambar'],
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Kookiez</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        background-color: #FDE2E4;
        color: #333;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h1 {
        text-align: center;
        color: #5C4033;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background-color: #f8d4da;
        color: #5C4033;
    }

    td img {
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .cart-total {
        float: right;
        width: 300px;
        border: 2px solid #5C4033;
        background-color: #fff7f9;
        padding: 20px;
        border-radius: 10px;
    }

    .cart-total h3 {
        margin-top: 0;
        color: #5C4033;
        font-size: 1.3em;
    }

    .cart-total p {
        font-size: 1.2em;
        margin: 10px 0;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        color: white;
        text-align: center;
        text-decoration: none;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1.1em;
        margin-top: 15px;
    }

    .checkout-btn:hover {
        background-color: #218838;
    }

    .empty-cart {
        text-align: center;
        padding: 50px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .empty-cart h2 {
        color: #5C4033;
        margin-bottom: 10px;
    }

    .empty-cart p {
        color: #666;
        margin-bottom: 20px;
    }

    .footer {
        text-align: center;
        padding: 20px;
        margin-top: 40px;
        background-color: #f2f2f2;
        color: #666;
        border-top: 1px solid #ddd;
    }

    a {
        color: #5C4033;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>

    <header class="header">
        </header>

    <div class="container">
        <h1>Keranjang Belanja Anda</h1>
        
        <?php if (!empty($produk_di_keranjang)): ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk_di_keranjang as $item): ?>
                    <tr>
                        <td><img src="gambar/<?php echo htmlspecialchars($item['gambar']); ?>" width="80"></td>
                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                        <td>Rp <?php echo number_format($item['harga']); ?></td>
                        <td><?php echo $item['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($item['subtotal']); ?></td>
                        <td><a href="#">Hapus</a></td> </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-total">
                <h3>Total Belanja</h3>
                <p><strong>Rp <?php echo number_format($total_harga); ?></strong></p>
<a href="checkout.php" class="checkout-btn">Lanjut ke Checkout</a>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <h2>Keranjang Anda kosong.</h2>
                <p>Ayo jelajahi produk kami dan temukan cookies favoritmu!</p>
                <a href="produk.php" class="checkout-btn" style="width: 200px; margin: auto;">Mulai Belanja</a>
            </div>
        <?php endif; ?>

    </div>

    <footer class="footer">
        </footer>

</body>
</html>