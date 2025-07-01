<?php
session_start();
include 'koneksi.php';
$pesan = '';

if (isset($_GET['status']) && $_GET['status'] == 'sukses_register') {
    $pesan = "Registrasi berhasil! Silakan login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM nadira_pengguna WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // ... (setelah password_verify berhasil)
$_SESSION['user_id'] = $user['id_pengguna'];
$_SESSION['user_nama'] = $user['nama_lengkap'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['peran']; // <-- Peran sudah disimpan di session, bagus!

// --- LOGIKA REDIRECT BERDASARKAN PERAN ---
if ($user['peran'] == 'admin') {
    // Jika peran adalah admin, arahkan ke dashboard admin
    header("Location: admin_dashboard.php");
    exit();
} else {
    // Jika peran adalah pelanggan, arahkan ke halaman utama
    header("Location: index.php");
    exit();
}
 } else {
            $pesan = "Password salah.";
        }
    } else {
        $pesan = "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Kookiez</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #FDE2E4;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .form-auth-container {
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: #fff;
        border: 2px solid #F8C8DC;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    h1 {
        text-align: center;
        color: #5C4033;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #5C4033;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 1em;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #8B4513;
        color: white;
        font-size: 1.1em;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    button:hover {
        background-color: #5C4033;
    }

    .pesan {
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }

    .pesan.sukses {
        color: #28a745;
    }

    .pesan.error {
        color: #DC3545;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
        font-size: 0.95em;
    }

    .register-link a {
        color: #8B4513;
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
    <div class="form-auth-container">
        <h1>Login Kookiez</h1>
        <?php 
        if ($pesan) { 
            $class = (isset($_GET['status'])) ? 'sukses' : 'error';
            echo "<p class='pesan $class'>$pesan</p>"; 
        } 
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Belum punya akun? <a href="register.php">Register di sini</a></p>
        </div>
    </div>
</body>
</html>