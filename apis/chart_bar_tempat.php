<?php
require_once '../core/autoload.php';
$data = [];

if(isset($_GET['all'])) {
    $stmt = $conn->prepare('SELECT `tempat`.`nama` AS name, SUM(`kunjungan`.`total`) AS `y` FROM `kunjungan` LEFT JOIN `tempat` ON `tempat`.`id_tempat` = `kunjungan`.`id_tempat` LEFT JOIN `admin` ON `tempat`.`id_admin` = `admin`.`id_admin` GROUP BY `kunjungan`.`id_tempat` ORDER BY `y` DESC');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    if(!isset($_SESSION['id_admin'])) redirect('../admin/login.php');
    $stmt = $conn->prepare('SELECT `tempat`.`nama` AS name, SUM(`kunjungan`.`total`) AS `y` FROM `kunjungan` LEFT JOIN `tempat` ON `tempat`.`id_tempat` = `kunjungan`.`id_tempat` LEFT JOIN `admin` ON `tempat`.`id_admin` = `admin`.`id_admin` WHERE `admin`.`id_admin` = :id_admin GROUP BY `kunjungan`.`id_tempat` ORDER BY `y` DESC');
    $stmt->execute(['id_admin' => $_SESSION['id_admin']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
foreach($data as $key=>$row) {
    $data[$key]['y'] = (int)$row['y'];
}

sendJson($data);