<?php
require_once '../core/autoload.php';

if(isset($_GET['id_tempat'])) {
    $data = [];
    $stmt = $conn->prepare('SELECT `tanggal`, `total` FROM `kunjungan` WHERE `id_tempat` = :id_tempat');
    $stmt->execute(['id_tempat' => $_GET['id_tempat']]);
    $kunjungan = $stmt->fetchAll(PDO::FETCH_CLASS);

    $period = new DatePeriod(
        new DateTime(date('Y-01-01')),
        new DateInterval('P1D'),
        (new DateTime(date('Y-m-d')))->modify('+1 day')
    );
    
    foreach($period as $date) {
        $day = $date->format('Y-m-d');
        $total = 0;
        foreach($kunjungan as $k) {
            if($day === $k->tanggal) {
                $total = (int)$k->total;
            }
        }
        array_push($data, [$day, $total]);
    }
    
    sendJson($data);
} else {
    sendJson([]);
}