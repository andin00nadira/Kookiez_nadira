<?php
session_start();
include 'koneksi.php';

// Jika keranjang kosong, redirect ke halaman produk
if (empty($_SESSION['keranjang'])) {
    header('Location: produk.php');
    exit();
}

// Logika untuk menampilkan ringkasan belanja (copy-paste dari keranjang.php)
$keranjang = $_SESSION['keranjang'];
$total_harga = 0;
$ids_produk = array_keys($keranjang);
$ids_string = implode(',', $ids_produk);
$query = "SELECT * FROM nadira_produk WHERE id_produk IN ($ids_string)";
$result = mysqli_query($koneksi, $query);
$produk_di_keranjang = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jumlah = $keranjang[$row['id_produk']];
    $total_harga += $row['harga'] * $jumlah;
    $produk_di_keranjang[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Kookiez</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        background-color: #FDE2E4; /* Pink lembut */
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
    .footer {
        text-align: center;
        padding: 20px;
        margin-top: 40px;
        background-color: #FADADD;
        color: #5C4033;
        border-top: 1px solid #ddd;
    }
    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fffafc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(92, 64, 51, 0.2);
    }
    h1, h2 {
        color: #8B0000;
    }
    .checkout-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }
    .form-container {
        padding: 20px;
        border: 1px solid #ccc;
        background-color: #fff0f3;
        border-radius: 10px;
    }
    .order-summary {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #FDF1F4;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #5C4033;
    }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .summary-total {
        font-weight: bold;
        font-size: 1.2em;
        border-top: 1px solid #ccc;
        padding-top: 10px;
        margin-top: 10px;
        color: #5C4033;
    }
    .place-order-btn {
        width: 100%;
        padding: 15px;
        font-size: 1.1em;
        background-color: #5C4033;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .place-order-btn:hover {
        background-color: #7B5E57;
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="proses_checkout.php" method="POST">
            <div class="checkout-layout">
                <div class="form-container">
                    <h2>Alamat Pengiriman</h2>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="4" required></textarea>
                    </div>
                </div>
                <div class="order-summary">
                    <h2>Ringkasan Pesanan</h2>
                    <?php foreach ($produk_di_keranjang as $item): ?>
                    <div class="summary-item">
                        <span><?php echo htmlspecialchars($item['nama_produk']); ?> x <?php echo $keranjang[$item['id_produk']]; ?></span>
                        <span>Rp <?php echo number_format($item['harga'] * $keranjang[$item['id_produk']]); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span>Rp <?php echo number_format($total_harga); ?></span>
                    </div>
                    <input type="hidden" name="total_harga" value="<?php echo $total_harga; ?>">
                    <button type="submit" class="place-order-btn">Buat Pesanan</button>
                </div>
            </div>
        </form>
    </div>
    </body>
</html>