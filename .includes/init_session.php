<?php
session_start();
$userId = $_SESSION["user_id"];
$name = $_SESSION["name"];
$role = $_SESSION["role"];
// ambil notifikasi jika, kemudian hapus dari sesi
$notification = $_SESSION['notification'] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}
if(empty($_SESSION["username"]) || empty($_SESSION["role"])){
$_SESSION['notification']=[
    'type'=> 'danger',
    'mesagge'=> 'silahkan login terlebih dahulu!'
];
header('location: ./auth/login.php');
exit();
}