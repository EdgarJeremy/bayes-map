<?php

/**
 * Dump die
 */
if(!function_exists('dd')) {
    function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
}

/**
 * Redirect
 */
if(!function_exists('redirect')) {
    function redirect($loc) {
        header('Location: ' . $loc);
        exit();
    }
}

/**
 * Send JSON
 */
if(!function_exists('sendJson')) {
    function sendJson($data) {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($data);
        exit();
    }
}

/**
 * Shortify String
 */
if(!function_exists('shortify')) {
    function shortify($str = "", $limit, $link = true) {
        $real = $str;
        $str = strip_tags($str);
        if(strlen($str) > $limit) {
            $strCut = substr($str, 0, $limit);
            $endPoint = strrpos($strCut, ' ');
            $str = $endPoint ? substr($strCut, 0, $endPoint) : substr($strCut, 0);
            if($link)
                $str .= '...[<a href="#" data-real="'.$real.'" class="show-more">Lengkap</a>]';
            else
                $str .= '...';
        }
        return $str;
    }
}

/**
 * Get User IP
 */
if(!function_exists('getIP')) {
    function getIP() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }
}

/**
 * Track Visit
 */
if(!function_exists('trackVisit')) {
    function trackVisit() {
        global $conn;
        $ip = getIP();
        $stmt = $conn->prepare('SELECT COUNT(*) AS `total` FROM `web_visits` WHERE `ip` = :ip');
        $stmt->execute(['ip' => $ip]);
        $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
        if($total > 0) {
            $stmt = $conn->prepare('UPDATE `web_visits` SET `click` = `click` + 1 WHERE `ip` = :ip');
            $stmt->execute(['ip' => $ip]);
        } else {
            $stmt = $conn->prepare('INSERT INTO `web_visits` (`ip`, `click`, `tanggal`) VALUES (:ip, :click, :tanggal)');
            $stmt->execute(['ip' => $ip, 'click' => 0, 'tanggal' => date('Y-m-d')]);
        }
    }
}

/**
 * Get Web Visits
 */
if(!function_exists('getVisits')) {
    function getVisits() {
        global $conn;
        $stmt = $conn->prepare('
            SELECT (SELECT COUNT(*) FROM `web_visits` WHERE DATE(`tanggal`) = :tanggal) AS today, (SELECT COUNT(*) FROM `web_visits`) AS total, (SELECT SUM(`click`) FROM `web_visits`) AS click;
        ');
        $stmt->execute(['tanggal' => date('Y-m-d')]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}