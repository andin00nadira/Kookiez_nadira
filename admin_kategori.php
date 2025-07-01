<?php
include 'cek_admin.php';
include 'koneksi.php';

$pesan = '';
$mode_edit = false;
$kategori_edit = ['id_kategori' => '', 'nama_kategori' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_kategori_edit'])) {
        $id = $_POST['id_kategori_edit'];
        $nama = $_POST['nama_kategori'];
        $query = "UPDATE nadira_kategori SET nama_kategori='$nama' WHERE id_kategori='$id'";
        $pesan = mysqli_query($koneksi, $query) ? "Kategori berhasil diperbarui." : "Gagal memperbarui kategori.";
    } else {
        $nama = $_POST['nama_kategori'];
        $query = "INSERT INTO nadira_kategori (nama_kategori) VALUES ('$nama')";
        $pesan = mysqli_query($koneksi, $query) ? "Kategori baru berhasil ditambahkan." : "Gagal menambahkan kategori.";
    }
}

if (isset($_GET['edit'])) {
    $mode_edit = true;
    $id = $_GET['edit'];
    $query = "SELECT * FROM nadira_kategori WHERE id_kategori='$id'";
    $result = mysqli_query($koneksi, $query);
    $kategori_edit = mysqli_fetch_assoc($result);
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $cek_produk = "SELECT COUNT(*) AS jumlah FROM nadira_produk WHERE id_kategori='$id'";
    $hasil_cek = mysqli_query($koneksi, $cek_produk);
    $jumlah_produk = mysqli_fetch_assoc($hasil_cek)['jumlah'];

    if ($jumlah_produk > 0) {
        $pesan = "Gagal menghapus: Kategori ini masih digunakan oleh produk lain.";
    } else {
        $query = "DELETE FROM nadira_kategori WHERE id_kategori='$id'";
        $pesan = mysqli_query($koneksi, $query) ? "Kategori berhasil dihapus." : "Gagal menghapus kategori.";
    }
}

$query_tampil = "SELECT * FROM nadira_kategori ORDER BY id_kategori DESC";
$result_tampil = mysqli_query($koneksi, $query_tampil);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manajemen Kategori</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FDE2E4;
            color: #4A4A4A;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            margin: 40px auto;
            background-color: #ffffffcc;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(92, 64, 51, 0.3);
        }
        h1, h2 {
            color: #8B0000;
            text-align: center;
        }
        .pesan {
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-container {
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff0f3;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: center;
        }
        input[type="text"] {
            width: 60%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #5C4033;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 10px;
        }
        button:hover {
            background-color: #7B5E57;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Kategori</h1>

        <?php if ($pesan): ?>
            <div class="pesan"><?php echo $pesan; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <h2><?php echo $mode_edit ? 'Edit Kategori' : 'Tambah Kategori Baru'; ?></h2>
            <form action="admin_kategori.php" method="post">
                <?php if ($mode_edit): ?>
                    <input type="hidden" name="id_kategori_edit" value="<?php echo $kategori_edit['id_kategori']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <input type="text" name="nama_kategori" placeholder="Nama Kategori" value="<?php echo htmlspecialchars($kategori_edit['nama_kategori']); ?>" required>
                    <button type="submit"><?php echo $mode_edit ? 'Simpan Perubahan' : 'Tambah'; ?></button>
                </div>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($result_tampil)): ?>
                <tr>
                    <td><?php echo $data['id_kategori']; ?></td>
                    <td><?php echo htmlspecialchars($data['nama_kategori']); ?></td>
                    <td class="action-links">
                        <a href="admin_kategori.php?edit=<?php echo $data['id_kategori']; ?>">Edit</a>
                        <a href="admin_kategori.php?hapus=<?php echo $data['id_kategori']; ?>" onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
