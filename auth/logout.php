<?php
session_start(); // memulai sesi
session_unset(); // menghapus semua data sesi
session_destroy(); // menghancurkan sesi sepenuhnya
header('Location: login.php'); // arahkan pengguna ke halaman login
exit(); // menghentikan eksekusi script