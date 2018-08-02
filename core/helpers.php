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