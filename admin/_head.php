<?php
require_once '../core/autoload.php';
if(!isset($_SESSION['id_admin'])) redirect('./login.php?error=Anda harus login');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Dashboard</title>

        <link rel="stylesheet" href="../assets/icon/css/open-iconic-bootstrap.css">
        <!-- Bootstrap core CSS -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous" />

        <!-- Custom styles for this template -->
        <link href="../assets/css/navbar-top-fixed.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/dashboard.css" />
        
        <script src="../assets/js/gmaps.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/6.0.3/highstock.js"></script>
    </head>

    <body>

        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <!-- <li class="nav-item active">
                            <a class="nav-link" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../">Publik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li> -->
                    </ul>
                    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="./logout.php"><span class="oi oi-account-logout"></span> Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
