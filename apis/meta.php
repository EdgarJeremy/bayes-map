<?php
require_once '../core/autoload.php';

if(isset($_GET['id_tempat'])) {
    $stmt = $conn->prepare('SELECT SUM(`total`) AS `kunjungan`, DAYNAME(`tanggal`) AS `hari` FROM `kunjungan` WHERE `id_tempat` = :id_tempat GROUP BY `hari` ORDER BY `kunjungan` DESC');
    $stmt->execute(['id_tempat' => $_GET['id_tempat']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    foreach($data as $i=>$item){
        $data[$i]['hari'] = $hari[$data[$i]['hari']];
    }
    trackVisit();

    sendJson($data);
}