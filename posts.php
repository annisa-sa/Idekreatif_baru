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
<!--dropdown untuk memilih kategori-->
<div class="mb-3">
    <label for="category_id" class="form-label">kategori</label>
    <select class="form-select" name="category_id" required>
        <!--mengambil data kategori dari database untuk mengisi
         opsi dropdown-->
        <option value="" selected disabled>pilih salah satu</option>
        <?php
        $query = "SELECT * FROM categories"; //query untuk mengambil data kategori
        $result = $conn->query($query); //menjalankan query if($result->num_rows>0) { //jika terdapat data kategori
        while($row=$result->fetch_assoc()) { //iterasi setiap kategori
            echo "<option value='" . $row["category_id"] . "'>"
            . $row["category_name"] . "</option";
        }
    ?>
    </select>
    </div>
    <!-- textarea untuk konten postingan-->
 <div class="mb-3">
    <label for="content" class="form-label">konten</label>
    <textarea class="form-control" id="content" name="content" required></textarea>
    </div>
    <!-- tombol sumbit-->
     <button type="submit" name="simpan" class="btn btn-primary">simpan</button>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <?php
    //menyertakan footer halaman 
    include '.includes/footer.php';
    ?>