<?php
// Sertakan file koneksi
include 'koneksi.php';

// --- SCRIPT UNTUK PROSES UPDATE DATA ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $gambar_lama = $_POST['gambar_lama']; // Ambil nama gambar lama

    // Cek apakah ada gambar baru yang diupload
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $target_dir = "gambar/";
        $target_file = $target_dir . basename($gambar);
        move_uploaded_file($gambar_tmp, $target_file);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $gambar = $gambar_lama;
    }

    // Query untuk update data produk
    $query = "UPDATE nadira_produk SET 
              nama_produk='$nama_produk', 
              id_kategori='$id_kategori', 
              deskripsi='$deskripsi', 
              harga='$harga', 
              stok='$stok', 
              gambar='$gambar' 
              WHERE id_produk='$id_produk'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: admin_produk.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// --- SCRIPT UNTUK MENGAMBIL DATA PRODUK YANG AKAN DIEDIT ---
// Cek apakah ada ID di URL
if (!isset($_GET['id'])) {
    header("Location: admin_produk.php");
    exit();
}

$id_produk = $_GET['id'];

// Query untuk mengambil data produk berdasarkan ID
$query_produk = "SELECT * FROM nadira_produk WHERE id_produk='$id_produk'";
$result_produk = mysqli_query($koneksi, $query_produk);
$produk = mysqli_fetch_assoc($result_produk);

// Jika produk dengan ID tersebut tidak ditemukan
if (!$produk) {
    echo "Produk tidak ditemukan!";
    exit();
}

// Query untuk mengambil semua data kategori
$kategori_query = "SELECT * FROM nadira_kategori";
$kategori_result = mysqli_query($koneksi, $kategori_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Edit Produk</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #FDE2E4;
        margin: 0;
        color: #333;
    }

    .container {
        width: 55%;
        margin: 40px auto;
        padding: 30px;
        background-color: #fffafc;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(92, 64, 51, 0.1);
    }

    h1 {
        text-align: center;
        color: #5C4033;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #5C4033;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1em;
    }

    .form-group button {
        padding: 12px 20px;
        background-color: #5C4033;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 1em;
        transition: background-color 0.3s;
    }

    .form-group button:hover {
        background-color: #7B5E57;
    }

    .current-image {
        margin-top: 10px;
    }

    .current-image p {
        margin-bottom: 5px;
        font-style: italic;
        color: #444;
    }

    .current-image img {
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Edit Produk</h1>
        <form action="edit_produk.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
            <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($produk['gambar']); ?>">

            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_kategori">Kategori:</label>
                <select id="id_kategori" name="id_kategori" required>
                    <?php
                    while($kategori = mysqli_fetch_assoc($kategori_result)) {
                        // Beri atribut 'selected' jika ID kategori sama dengan ID kategori produk
                        $selected = ($kategori['id_kategori'] == $produk['id_kategori']) ? 'selected' : '';
                        echo '<option value="'.$kategori['id_kategori'].'" '.$selected.'>'.htmlspecialchars($kategori['nama_kategori']).'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" value="<?php echo $produk['harga']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" value="<?php echo $produk['stok']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Produk (Kosongkan jika tidak ingin diubah):</label>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                <div class="current-image">
                    <p>Gambar saat ini:</p>
                    <img src="gambar/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="Gambar Produk" width="100">
                </div>
            </div>
            <div class="form-group">
                <button type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>