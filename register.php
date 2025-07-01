<?php
include 'koneksi.php';
$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Cek apakah email sudah terdaftar
    $cek_email = "SELECT * FROM nadira_pengguna WHERE email = '$email'";
    $hasil_cek = mysqli_query($koneksi, $cek_email);

    if (mysqli_num_rows($hasil_cek) > 0) {
        $pesan = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO nadira_pengguna (nama_lengkap, email, password, alamat, peran) VALUES ('$nama', '$email', '$hashed_password', '$alamat', 'pelanggan')";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: login.php?status=sukses_register");
            exit();
        } else {
            $pesan = "Registrasi gagal. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Kookiez</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        background-color: #FFF5F7;
        color: #333;
    }

    .form-auth-container {
        width: 420px;
        margin: 80px auto;
        padding: 30px;
        border: 1px solid #FADADD;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
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
    .form-group textarea {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #D2691E;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    button:hover {
        background-color: #A0522D;
    }

    .pesan {
        color: red;
        margin-bottom: 15px;
        text-align: center;
        font-weight: bold;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        font-size: 0.95em;
    }

    .login-link a {
        color: #D2691E;
        text-decoration: none;
    }

    .login-link a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
    <div class="form-auth-container">
        <h1>Buat Akun Kookiez</h1>
        <?php if ($pesan) { echo "<p class='pesan'>$pesan</p>"; } ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
             <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>