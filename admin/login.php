<?php
require_once '../core/autoload.php';
if(isset($_SESSION['id_admin'])) redirect('./dashboard.php');
if(isset($_POST['btnSubmit'])) {
    if(!isset($_POST['email'])) {
        redirect('./register.php?error=Isi field email');
    } elseif(!isset($_POST['password'])) {
        redirect('./register.php?error=Isi field password');
    } else {
        $stmt = $conn->prepare('SELECT `id_admin`, `nama`, `email` FROM `admin` WHERE `email` = :email AND password = :password');
        $stmt->execute(['email' => $_POST['email'], 'password' => md5($_POST['password'])]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data) {
            $_SESSION = $data;
            redirect('./dashboard.php');
        } else {
            redirect('./login.php?error=Login tidak valid');
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

        <title>Masuk</title>

        <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous" />

        <!-- Custom styles for this template -->
        <link href="../assets/css/signin.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <form class="form-signin" method="post">
            <!-- <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
            <h1 class="h3 mb-3 font-weight-normal">Masuk dengan akun anda</h1>
            <?php if(isset($_GET['error'])):?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error'];?>
                </div>
            <?php endif;?>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button name="btnSubmit" class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button><br />
            <p class="text-center"><a href="./register.php">Belum punya akun?</a></p>
            <p class="text-center"><a href="../">Beranda</a></p>
            <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
        </form>
    </body>
</html>