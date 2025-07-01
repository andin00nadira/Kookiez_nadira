<?php
// Sertakan file koneksi
include 'koneksi.php';

// --- SCRIPT UNTUK PROSES SUBMIT FORM ---
// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Proses upload gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = "gambar/"; // Folder tempat menyimpan gambar
    $target_file = $target_dir . basename($gambar);

    // Pindahkan file gambar yang diupload ke folder tujuan
    if (move_uploaded_file($gambar_tmp, $target_file)) {
        // Jika gambar berhasil diupload, simpan data ke database
        $query = "INSERT INTO nadira_produk (nama_produk, id_kategori, deskripsi, harga, stok, gambar) 
                  VALUES ('$nama_produk', '$id_kategori', '$deskripsi', '$harga', '$stok', '$gambar')";
        
        if (mysqli_query($koneksi, $query)) {
            // Jika berhasil, redirect ke halaman admin produk
            header("Location: admin_produk.php");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload gambar.";
    }
}

// --- SCRIPT UNTUK MENGAMBIL DATA KATEGORI ---
// Query untuk mengambil semua data dari tabel kategori
$kategori_query = "SELECT * FROM nadira_kategori";
$kategori_result = mysqli_query($koneksi, $kategori_query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tambah Produk</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #FFF5F7;
        margin: 0;
        color: #333;
    }

    .container {
        width: 500px;
        margin: 50px auto;
        background-color: #fff;
        padding: 30px;
        border: 1px solid #FADADD;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    h1 {
        text-align: center;
        color: #5C4033;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #5C4033;
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1em;
    }

    .form-group input[type="file"] {
        padding: 6px;
    }

    .form-group button {
        width: 100%;
        padding: 12px;
        background-color: #D2691E;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1.1em;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .form-group button:hover {
        background-color: #A0522D;
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Tambah Produk Baru</h1>
        <form action="tambah_produk.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="form-group">
                <label for="id_kategori">Kategori:</label>
                <select id="id_kategori" name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    // Looping untuk menampilkan opsi kategori dari database
                    if (mysqli_num_rows($kategori_result) > 0) {
                        while($kategori = mysqli_fetch_assoc($kategori_result)) {
                            echo '<option value="'.$kategori['id_kategori'].'">'.htmlspecialchars($kategori['nama_kategori']).'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Produk:</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan Produk</button>
            </div>
        </form>
    </div>
</body>
</html>