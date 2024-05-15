<?php
@include 'config.php';
session_start();

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $select = "SELECT * FROM users_form WHERE email = '$email' && password = '$password'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if($row['user_type'] == 'admin') {
            $_SESSION['admin_fullname'] = $row['fullname'];
            header('location:adminPage.php');
            exit();
        } elseif($row['user_type'] == 'user') {
            $_SESSION['user_fullname'] = $row['fullname'];
            header('location:userPage.php');
            exit();
        }
    } else {
        $error[] = 'incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-image">
                <img src="img/login-img.jpg" alt="Gambar Login">
            </div>
            <div class="login-form">
                <form action="loginPage.php" method="post">
                    <h1>Halo,</h1>
                    <p>Silahkan Login untuk melanjutkan</p>
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="example@gmail.com" required>
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                    <button type="submit" name="submit">Login</button>
                    <p>Belum punya akun? <a href="registerPage.php">Daftar</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
