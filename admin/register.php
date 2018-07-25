<?php
require_once '../core/autoload.php';
if(isset($_SESSION['id_admin'])) redirect('./dashboard.php');
if(isset($_POST['btnSubmit'])) {
    if(!isset($_POST['nama'])) {
        redirect('./register.php?error=Isi field nama');
    } elseif(!isset($_POST['email'])) {
        redirect('./register.php?error=Isi field email');
    } elseif(!isset($_POST['password'])) {
        redirect('./register.php?error=Isi field password');
    } elseif(!isset($_POST['r_password'])) {
        redirect('./register.php?error=Input ulang password');
    } else {
        if($_POST['password'] !== $_POST['r_password']) redirect('./register.php?error=Password tidak cocok');

        $stmt = $conn->prepare('INSERT INTO `admin`(`nama`, `email`, `password`) VALUES (:nama, :email, :password)');
        $data = [
            'nama' => $_POST['nama'],
            'email' => $_POST['email'],
            'password' => md5($_POST['password'])
        ];
        if($stmt->execute($data)) {
            redirect('./register.php?success');
        } else {
            redirect('./register.php?error=Terjadi kesalahan sistem');
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Daftar</title>

        <!-- Bootstrap core CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous" />

        <!-- Custom styles for this template -->
        <link href="../assets/css/signin.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <form class="form-signin" method="post">
            <!-- <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
            <h1 class="h3 mb-3 font-weight-normal">Daftar akun baru</h1><hr />
            <?php if(isset($_GET['error'])):?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error'];?>
                </div>
            <?php endif;?>
            <?php if(isset($_GET['success'])):?>
                <div class="alert alert-success" role="alert">
                    Berhasil mendaftar. Silahkan <a href="./login.php">login</a>
                </div>
            <?php endif;?>
            <label for="inputEmail" class="sr-only">Nama</label>
            <input name="nama" type="text" id="inputNama" class="form-control" placeholder="Nama" required autofocus>
            <label for="inputEmail" class="sr-only">Email</label>
            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <label for="inputRPassword" class="sr-only">Ketik Ulang Password</label>
            <input name="r_password" type="password" id="inputRPassword" class="form-control" placeholder="Ketik Ulang Password" required><br />
            <button name="btnSubmit" class="btn btn-lg btn-primary btn-block" type="submit">Daftar</button><hr />
            <p class="text-center"><a href="./login.php">Sudah punya akun?</a></p>
            <p class="text-center"><a href="../">Beranda</a></p>
            <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
        </form>
    </body>
</html>