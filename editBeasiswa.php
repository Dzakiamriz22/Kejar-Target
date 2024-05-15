<?php
// Include file konfigurasi dan jalankan session
@include 'config.php';
session_start();

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['admin_fullname'])) {
    header('location:loginPage.php');
    exit();
}

// Inisialisasi variabel pesan kesalahan
$error = '';

// Cek apakah parameter id_bea diteruskan melalui URL
if (!isset($_GET['id'])) {
    header('location:dataBeasiswa.php'); // Jika tidak, redirect kembali ke halaman data beasiswa
    exit();
}

$id_beasiswa = $_GET['id'];

// Ambil data beasiswa dari database berdasarkan id_bea yang diteruskan
$sql = "SELECT * FROM list_bea WHERE id_bea = '$id_beasiswa'";
$result = mysqli_query($conn, $sql);

// Cek apakah data beasiswa ditemukan
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
} else {
    // Jika tidak ditemukan, redirect kembali ke halaman data beasiswa
    header('location:dataBeasiswa.php');
    exit();
}

// Proses form jika ada data yang disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirimkan dari form
    $nama_bea = $_POST['nama_bea'];
    $deadline = $_POST['deadline'];
    $link = $_POST['link'];

    // Update data beasiswa di database
    $update_sql = "UPDATE list_bea SET nama_bea='$nama_bea', deadline='$deadline', link='$link' WHERE id_bea='$id_beasiswa'";
    if (mysqli_query($conn, $update_sql)) {
        // Jika berhasil, redirect kembali ke halaman data beasiswa
        header('location:dataBeasiswa.php');
        exit();
    } else {
        // Jika gagal, tangani kesalahan
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Beasiswa</title>
    <link rel="stylesheet" href="css/editBeasiswa.css">
</head>
<body>
   
<div class="container">
   <div class="sidebar">
      <!-- Navbar -->
      <nav class="navbar">
         <ul>
            <li><h2>KEJAR TARGET</h2></li>
            <li><a href="adminPage.php">Data Pengguna</a></li>
            <li><a href="dataBeasiswa.php">Data Beasiswa</a></li>
            <li><a href="loginPage.php">Logout</a></li>
         </ul>
      </nav>
   </div>
   <div class="content">
      <h1>Edit Beasiswa</h1>

      <!-- Formulir Pengeditan -->
      <form class="form-bea" method="post">
         <div>
            <label for="nama_bea">Nama Beasiswa:</label>
            <input type="text" id="nama_bea" name="nama_bea" value="<?php echo $row['nama_bea']; ?>">
         </div>
         <div>
            <label for="deadline">Batas Pendaftaran:</label>
            <input type="date" id="deadline" name="deadline" value="<?php echo $row['deadline']; ?>">
         </div>
         <div>
            <label for="link">Link Pendaftaran:</label>
            <input type="text" id="link" name="link" value="<?php echo $row['link']; ?>">
         </div>
         <div>
            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"><?php echo $row['deskripsi']; ?></textarea>
         </div>
         <input type="submit" value="Simpan">
      </form>
   </div>
</div>

</body>
</html>