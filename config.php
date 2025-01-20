<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "idekreatif";

$conn = mysqli_connect($host, $username, $password, $database);
if ($conn->connect_error) {
die("Database gagal tekoneksi: " . $conn->connect_eror);
}
?>