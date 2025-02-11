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

// Proses penghapusan postingan 
if (isset($_POST['delete'])) {
    // Mengambil ID post dari prameter URL
    $postID = $_POST['postID'];
    
    // Query untuk menghapus post berdasarkan ID
    $exec = mysqli_query($conn, "DELETE FROM post WHERE id_post='$postID");

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Post successfully deleted.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'error deleting post: ' . mysqli_error($conn)
        ];
    }

    //redirect kembali ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}

// Menangani pembaruan data postingan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Mendapatkan data dari form
    $postId = $_POST['post_id'];
    $postTitle = $_POST["post_title"];
    $content = $_POST['content'];
    $categoryId = $_POST["category_id"];
    $imageDir = "assets/img/uploads/"; // Direktori penyimpanan gambar

    // Periksa apakah file gambar baru diunggah
    if (!empty($_FILES["image_path"]["name"])) {
        $imageName = $_FILES["image_path"]["name"];
        $imagePath = $imageDir . $imageName;
    
        // Pindahkan file baru ke direktori tujuan
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath);
    
        // Hapus gambar lama
        $queryOldImage = "SELECT image_path FROM posts WHERE id_post = $postId";
        $resultOldImage = $conn->query($queryOldImage);
        if ($resultOldImage->num_rows > 0) {
            $oldImage = $resultOldImage->fetch_assoc()['image_path'];
            if (file_exists($oldImage)) {
                unlink($oldImage); // Menghapus file lama
            }
        }
    } else {
        // Jika tidak ada file baru, gunakan gambar lama
        $imagePathQuery = "SELECT image_path FROM posts WHERE id_post = $postId";
        $result = $conn->query($imagePathQuery);
        $imagePath = ($result->num_rows > 0) ? $result->fetch_assoc()['image_path'] : null;
    }
    
    // Update data postingan di database
    $queryUpdate = "UPDATE posts SET post_title = '$postTitle',
        content = '$content', category_id = $categoryId, 
        image_path = '$imagePath' WHERE id_post = $postId";
    
    if ($conn->query($queryUpdate) === TRUE) {
        // Notifikasi berhasil
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Postingan berhasil diperbarui.'
        ];
    } else {
        // Notifikasi gagal
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui postingan.'
        ];
    }
    
    // Arahkan ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}