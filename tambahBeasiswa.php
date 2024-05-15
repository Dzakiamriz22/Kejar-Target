<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_fullname'])){
   header('location:loginPage.php');
   exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $namaBeasiswa = mysqli_real_escape_string($conn, $_POST['namaBea']);
    $deskripsiBeasiswa = mysqli_real_escape_string($conn, $_POST['deskripsiBea']);
    $tanggalDaftar = $_POST['tanggalDaftar'];
    $linkDaftar = mysqli_real_escape_string($conn, $_POST['linkDaftar']);

    // Query to insert data into database
    $sql = "INSERT INTO list_bea (nama_bea, deskripsi, deadline, link) VALUES ('$namaBeasiswa', '$deskripsiBeasiswa', '$tanggalDaftar', '$linkDaftar')";

    // Execute query
    if(mysqli_query($conn, $sql)) {
        // Redirect user back to dataBeasiswa.php after successful data insertion
        header("Location: dataBeasiswa.php");
        exit(); // Make sure to exit after redirection
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tambah Beasiswa</title>
   <link rel="stylesheet" href="css/tambahBeasiswa.css">
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
      <h2>Tambah Beasiswa</h2>

      <!-- Form Beasiswa -->
      <div class="form-bea">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="namaBea">Nama Beasiswa</label>
                <input type="text" name="namaBea" required>
            </div>
            <div>
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsiBea" rows="5" required></textarea>
            </div>
            <div>
                <label for="batasdaftar">Batas Pendaftaran</label>
                <input type="date" name="tanggalDaftar" required>
            </div>
            <div>
                <label for="link">Link Pendaftaran</label>
                <input type="text" name="linkDaftar" required>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
      </div> 
   </div>
</div>
</body>
</html>
