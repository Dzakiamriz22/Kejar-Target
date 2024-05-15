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

// Retrieve data beasiswa from database
$beasiswa_data = '';
$sql = "SELECT * FROM list_bea";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $beasiswa_data .= "<div class='beasiswa-item'>";
        $beasiswa_data .= "<h2>" . $row["nama_bea"] . "</h2>";
        $beasiswa_data .= "<p>Batas Pendaftaran: " . $row["deadline"] . "</p>";
        $beasiswa_data .= "<a href='detailBeasiswa.php?id={$row["id_bea"]}'>Detail</a>";
        $beasiswa_data .= "</div>";
    }
} else {
    $beasiswa_data = "<p>No available scholarships</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>
   <link rel="stylesheet" href="css/userPage.css">
</head>
<body>
   
<div class="container">
   <div class="sidebar">
      <!-- Navbar -->
      <nav class="navbar">
         <ul>
            <li><h2>KEJAR TARGET</h2></li>
            <li><a href="userPage.php">Home</a></li>
            <li><a href= "loginPage.php">Logout</a></li>
         </ul>
      </nav>
   </div>
   <div class="content">
      <h1>Welcome <span><?php echo $_SESSION['user_fullname'] ?></span></h1>
      <h2>Kejar Beasiswa, Raih Target Masa Depanmu! </h2>
      
      <!-- List Beasiswa -->
      <div class="beasiswa-list">
         <?php echo $beasiswa_data; ?>
      </div>
   </div>
</div>

</body>
</html>
