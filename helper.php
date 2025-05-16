<?php

function isLoggedIn()
{
    return isset($_SESSION['user']);
}
function printer($block)
{
    echo '<pre>';
    var_dump($block);
    echo '</pre>';
    die;
}
function baseURL()
{
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $base_url .= $_SERVER['HTTP_HOST'];
    return $base_url . '/az-news';
}
function limit_words($text, $limit)
{
    $words = explode(' ', $text);
    return implode(' ', array_slice($words, 0, $limit)) . (count($words) > $limit ? '...' : '');
}

function defaultImg()
{
    return 'https://g-btuwypcnlte.vusercontent.net';
}
?>