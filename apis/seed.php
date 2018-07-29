<?php
// require_once '../core/autoload.php';

// $period = new DatePeriod(
//     new DateTime(date('Y-03-01')),
//     new DateInterval('P1D'),
//     (new DateTime(date('Y-m-d')))->modify('+1 day')
// );
// $res = [];
// foreach($period as $date){
//     $stmt = $conn->prepare('INSERT INTO `kunjungan`(`tanggal`, `total`, `id_tempat`) VALUES (:tanggal, :total, :id_tempat)');
//     $res[] = $stmt->execute([
//         'tanggal' => $date->format('Y-m-d'),
//         'total' => rand(10, 50),
//         'id_tempat' => 26
//     ]);
// }

// sendJson($res);