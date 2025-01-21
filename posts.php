<?php
// Menyertakan header halaman
include '.includes/header.php';
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul Halaman -->
     <div class="row">
        <!-- Form untuk menambahkan postingan baru -->
         <div class="col-md-10">
            <div class="card mb-4">
                <div class="car-body">
                    <form method="POST" action="proses_post.php"
                    enctype="multipart/form-data">
                    <!--input untuk judul postingan-->
                    <div class="mb-3">
                        <label for="post_tittle" class="form-label">judul postingan</label>
                        <input type="text" class="form-control"name="post_tittle" required>
</div>
<!-- input untuk mengunggah gambar-->
 <div class="mb-3">
    <label for="formfile" class="form-label">unggah gambar</label>
    <input class="form-control" type="file" name="image" accept="image/*"/>
</div>
