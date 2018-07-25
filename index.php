<?php
require_once './core/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STATISTIK WISATA</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous" />
    <link rel="stylesheet" href="./assets/css/app.css" />
    <link rel="stylesheet" href="./assets/icon/css/open-iconic-bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    <!-- Google Maps Javascript API (AIzaSyAycCLQBE72kLbRXBqfCkRpMuwxFaeyIzE) -->
    <script src="./assets/js/gmaps.js"></script>
    <script src="./assets/js/app.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAycCLQBE72kLbRXBqfCkRpMuwxFaeyIzE&callback=initMap" async defer></script>
</head>
<body>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">STATISTIK WISATA</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php if(!isset($_SESSION['id_admin'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin/register.php">Daftar</a>
                    </li>
                    <?php else:?>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin/dashboard.php">Dashboard</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Cari Tempat.." aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>

    <div id="layer-place">
        <div class="card">
            <h4 class="card-header"><span class="oi oi-map-marker"></span> Tempat Wisata</h4>
            <div class="card-body">
                <ul class="list-group">
                    <a href="#" class="list-group-item active">Cras justo odio</a>
                    <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                    <a href="#" class="list-group-item">Morbi leo risus</a>
                    <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item">Vestibulum at eros</a>
                </ul>
            </div>
        </div>
    </div>

    <div id="map"></div>

</body>
</html>