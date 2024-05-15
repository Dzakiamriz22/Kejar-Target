<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_fullname'])){
   header('location:loginPage.php');
   exit();
}

// Jika terdapat aksi penghapusan (ketika tombol "Hapus" ditekan)
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_bea = $_GET['id'];
    // Query untuk menghapus data beasiswa berdasarkan ID
    $delete_query = "DELETE FROM list_bea WHERE id_bea = $id_bea";
    mysqli_query($conn, $delete_query);
    // Redirect kembali ke halaman dataBeasiswa setelah penghapusan
    header('location: dataBeasiswa.php');
    exit();
}

// Query untuk mengambil data beasiswa dari database
$sql = "SELECT * FROM list_bea";
$result = mysqli_query($conn, $sql);

// Mengambil data beasiswa satu per satu dan menampilkannya dalam tabel
$beasiswa_data = "";
while ($row = mysqli_fetch_assoc($result)) {
    $beasiswa_data .= "<tr>";
    $beasiswa_data .= "<td>{$row['id_bea']}</td>";
    $beasiswa_data .= "<td>{$row['nama_bea']}</td>";
    $beasiswa_data .= "<td>{$row['deadline']}</td>";
    $beasiswa_data .= "<td><a href='{$row['link']}'>{$row['link']}</a></td>";
    $beasiswa_data .= "<td>
                        <a href='editBeasiswa.php?id={$row['id_bea']}'>Edit</a> | 
                        <a href='dataBeasiswa.php?action=delete&id={$row['id_bea']}' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Delete</a>
                      </td>";
    $beasiswa_data .= "</tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Data Beasiswa</title>
   <link rel="stylesheet" href="css/dataBeasiswa.css">
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
      <h1>Welcome <span><?php echo $_SESSION['admin_fullname']; ?></span></h1>
      <h2>Data Beasiswa</h2>
      <a href="tambahBeasiswa.php" class="add-beasiswa-button">Tambah Data Beasiswa</a>

      <!-- List Beasiswa -->
      <div class="beasiswa-list">
         <div class="beasiswa-item">
            <table>
               <thead>
                  <tr>
                     <th>ID Beasiswa</th>
                     <th>Nama Beasiswa</th>
                     <th>Batas Pendaftaran</th>
                     <th>Link Pendaftaran</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php echo $beasiswa_data; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

</body>
</html>
