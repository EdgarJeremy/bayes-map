<?php
// require_once '../core/autoload.php';

// $period = new DatePeriod(
//     new DateTime(date('Y-01-01')),
//     new DateInterval('P1D'),
//     (new DateTime(date('Y-m-d')))->modify('+1 day')
// );
// $res = [];
// foreach($period as $date){
//     $stmt = $conn->prepare('INSERT INTO `kunjungan`(`tanggal`, `total`, `id_tempat`) VALUES (:tanggal, :total, :id_tempat)');
//     $res[] = $stmt->execute([
//         'tanggal' => $date->format('Y-m-d'),
//         'total' => rand(0, 1000),
//         'id_tempat' => 6
//     ]);
// }

// sendJson($res);