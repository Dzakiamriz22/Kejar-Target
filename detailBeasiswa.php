<?php
// Include file konfigurasi
@include 'config.php';

// Mulai sesi
session_start();

// Periksa apakah pengguna masuk atau tidak
if(!isset($_SESSION['user_fullname'])){
   header('location:loginPage.php');
   exit(); 
}

// Periksa apakah ID beasiswa disediakan dalam URL
if(isset($_GET['id'])) {
    $beasiswa_id = $_GET['id'];

    // Query untuk mengambil data beasiswa berdasarkan ID
    $sql = "SELECT * FROM list_bea WHERE id_bea = $beasiswa_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Tampilkan informasi beasiswa
        $nama_bea = $row['nama_bea'];
        $deskripsiBeasiswa = $row['deskripsi'];
        $deadline = $row['deadline'];
        $link = $row['link'];
    } else {
        // Jika tidak ada data beasiswa ditemukan dengan ID yang diberikan
        $nama_bea = "Beasiswa Tidak Ditemukan";
        $deskripsiBeasiswa = "";
        $deadline = "";
        $link = "#";
    }
} else {
    // Jika tidak ada ID beasiswa disediakan dalam URL
    $nama_bea = "Beasiswa Tidak Ditemukan";
    $deskripsiBeasiswa = "";
    $deadline = "";
    $link = "#";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Detail Beasiswa</title>
   <link rel="stylesheet" href="css/detailBeasiswa.css">
</head>
<body>
   
<div class="container">
   <div class="content">
      <h1>Detail Beasiswa</h1>
      <div class="beasiswa-detail">
         <h2><?php echo $nama_bea; ?></h2>
         <h3>Deskripsi: </h3>
         <p><?php echo $deskripsiBeasiswa; ?></p>
         <p>Batas Pendaftaran: <?php echo $deadline; ?></p>
         <p><a <?php echo $link; ?>> Link Pendaftaran </a></p>
      </div>
      <a href="userPage.php">Kembali ke Beranda</a>
   </div>
</div>

</body>
</html>     
