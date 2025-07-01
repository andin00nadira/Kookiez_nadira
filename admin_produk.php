<?php
include 'cek_admin.php';
include 'koneksi.php';

$query = "SELECT nadira_produk.*, nadira_kategori.nama_kategori 
          FROM nadira_produk 
          JOIN nadira_kategori ON nadira_produk.id_kategori = nadira_kategori.id_kategori
          ORDER BY nadira_produk.id_produk DESC";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manajemen Produk Kookiez</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FDE2E4;
            margin: 0;
            padding: 0;
            color: #4A4A4A;
        }
        .container {
            width: 85%;
            margin: 40px auto;
            background-color: #ffffffcc;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(92, 64, 51, 0.3);
        }
        h1 {
            text-align: center;
            color: #8B0000;
            margin-bottom: 30px;
        }
        .button-add {
            display: inline-block;
            padding: 10px 18px;
            background-color: #D291BC;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .button-add:hover {
            background-color: #7B5E57;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #FADADD;
            color: #5C4033;
        }
        tr:nth-child(even) {
            background-color: #FFF5F7;
        }
        img {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .action-links a {
            background-color: #D291BC;
            color: white;
            padding: 6px 12px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }
        .action-links a:hover {
            background-color: #7B5E57;
        }
        .action-links a.delete {
            background-color: #DC3545;
        }
        .action-links a.delete:hover {
            background-color: #a32330;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Produk</h1>
        <a href="tambah_produk.php" class="button-add">+ Tambah Produk Baru</a>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <?php if ($data['gambar']): ?>
                                <img src="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" alt="<?php echo htmlspecialchars($data['nama_produk']); ?>" width="80">
                            <?php else: ?>
                                <span>No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($data['nama_produk']); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_kategori']); ?></td>
                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($data['stok']); ?></td>
                        <td class="action-links">
                            <a href="edit_produk.php?id=<?php echo $data['id_produk']; ?>">Edit</a>
                            <a href="hapus_produk.php?id=<?php echo $data['id_produk']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="7" style="text-align:center;">Belum ada data produk.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($koneksi);
?>
