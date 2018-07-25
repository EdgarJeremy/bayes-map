<?php
require_once '../core/autoload.php';

if(isset($_SESSION['id_admin'])) {
    redirect('./dashboard.php');
} else {
    redirect('./login.php');
}