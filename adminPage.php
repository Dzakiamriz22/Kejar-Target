<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_fullname'])){
   header('location:loginPage.php');
   exit();
}

// Jika terdapat aksi penghapusan (ketika tombol "Hapus" ditekan)
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_user = $_GET['id'];
    // Query untuk menghapus data pengguna berdasarkan ID
    $delete_query = "DELETE FROM users_form WHERE id_user = $id_user";
    mysqli_query($conn, $delete_query);
    // Redirect kembali ke halaman adminPage setelah penghapusan
    header('location: adminPage.php');
    exit();
}

// Query untuk mengambil data pengguna dari database setelah penghapusan dilakukan
$query = "SELECT * FROM users_form";
$result = mysqli_query($conn, $query);

// Mengambil data pengguna satu per satu dan menampilkannya dalam tabel
$user_data = "";
while ($row = mysqli_fetch_assoc($result)) {
    $user_data .= "<tr>";
    $user_data .= "<td>{$row['id_user']}</td>";
    $user_data .= "<td>{$row['fullname']}</td>";
    $user_data .= "<td>{$row['email']}</td>";
    $user_data .= "<td>{$row['number']}</td>";
    $user_data .= "<td>{$row['age']}</td>";
    $user_data .= "<td>{$row['user_type']}</td>";
    $user_data .= "<td><a href='adminPage.php?action=delete&id={$row['id_user']}'>Hapus</a></td>";
    $user_data .= "</tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>
   <link rel="stylesheet" href="css/adminPage.css">
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
      <h2>Data Pengguna </h2>

      <!-- List User -->
      <div class="user-list">
         <div class="user-item">
            <table>
               <thead>
                  <tr>
                     <th>ID User</th>
                     <th>Nama Lengkap</th>
                     <th>Email</th>
                     <th>No HP</th>
                     <th>Usia</th>
                     <th>Role</th>
                     <th>Aksi</th> 
                  </tr>
               </thead>
               <tbody>
                  <?php echo $user_data; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

</body>
</html>
