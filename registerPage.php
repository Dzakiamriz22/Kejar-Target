<?php
@include 'config.php';
$error = array();

if (isset($_POST['submit'])){
  
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Check if email already exists
    $select = "SELECT * FROM users_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $error[] = 'User already exists!';
    } else {
        // Insert new user without specifying ID
        $insert = "INSERT INTO users_form (fullname, email, age, number, password, user_type) VALUES ('$fullname','$email','$age','$number','$password','$role')";
        if (mysqli_query($conn, $insert)) {
            header('location: loginPage.php');
            exit; 
        } else {
            $error[] = 'Error: ' . mysqli_error($conn); 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="register-page">
        <div class="register-container">    
            <div class="register-form">
                <form action="" method="post">
                    <h1>Daftar Akun</h1>
                    <?php
                    if(isset($error)){
                        foreach($error as $error){
                            echo '<span class ="error-msg">'.$error.'</span>';
                        }
                    }
                    ?>
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" placeholder="Masukkan Nama Lengkap" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="example@gmail.com" required>
                    <label for="age">Usia</label>
                    <input type="number" name="age" placeholder="Masukkan Usia" required>
                    <label for="number">Nomor HP</label>
                    <input type="text" name="number" placeholder="628xxxxxxxxxx" required>
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                    <label for="role">Role</label>
                    <select name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" name="submit">Daftar</button>
                    <p>Sudah punya akun? <a href="loginPage.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
