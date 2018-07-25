<?php
require_once '../core/autoload.php';
if(!isset($_SESSION['id_admin'])) redirect('./login.php');
if(isset($_GET['id_tempat'])) {
    $stmt = $conn->prepare('DELETE FROM `tempat` WHERE `id_tempat` = :id_tempat AND `id_admin` = :id_admin');
    if($stmt->execute([
        'id_tempat' => $_GET['id_tempat'],
        'id_admin' => $_SESSION['id_admin']
    ])) {
        redirect('./dashboard.php?successdelete');
    } else {
        redirect('./dashboard.php');
    }
} else {
    redirect('./dashboard.php');
}