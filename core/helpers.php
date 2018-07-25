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