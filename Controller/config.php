<?php
session_start();

$conn = mysqli_connect('localhost','root','','bananabash') or die('connection failed');

function redirect($url)
{
    echo "<script>window.location.href = '$url';</script>";
    die();
}

?>