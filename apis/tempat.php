<?php
require_once '../core/autoload.php';

if(isset($_GET['id_tempat'])) {
    $stmt = $conn->prepare('SELECT * FROM `tempat` WHERE id_tempat = :id_tempat');
    $stmt->execute(['id_tempat' => $_GET['id_tempat']]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    sendJson($data);
}