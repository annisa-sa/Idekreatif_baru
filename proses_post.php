<?php
//menghubungkan file konfigurasi database
include 'config.php';

//memulai sesi php
session_start();

//mendapatkan ID pengguna dari sesi
$userId = $_SESSION["user_id"];

//menangani form untuk menambahkan postingan baru
if(isset($_POST['simpan'])) {
//mendapatkan data dari form
$postTitle =$_POST["post_tittle"]; // judul postingan
$content =$_POST["content"]; //konten postingan
$categoryId =$_POST["category_id"]; //ID kategori

//menatur direktori penyimpanan file gambar
$imageDir ="assets/imf/uploads/";
$imageName =$_FILES["image"]["name"]; //nama file gambar
$imagePath =$imageDir . basename($imageName); //path lengkap gambar

//memindahkan file gambar yang di unggah ke direktori tujuan
if(move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)){
//jika unggahan berhasil,masukkan
//data postingan ke dalam database
$query ="INSERT INTO posts(post_tittle,content,
created_at,category_id,user_id,image_path) VALUES
('$postTittle','$content',NOW(), $categoryId,$userId,
'$imagePath')";
if ($conn->query($query) === TRUE) {
    // Notifikasi berhasil jika postingan berhasil ditambahkan
    $_SESSION['notification'] = [
        'type' => 'primary',
        'message' => 'Post successfully addec.'
    ];
} else {
    // Notifikasi error jika gagal menambahkan postingan
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error adding post: ' . $conn->error
    ];
}
} else {
// Notifikasi error jika unggahan gambar gagal
$_SESSION['notification'] = [
    'type' => 'danger',
    'message' => 'Failed to upload image.'
];
}

// Arahkan ke halaman dashboard setelah selesai
header('Location: dashboard.php');
exit();
}