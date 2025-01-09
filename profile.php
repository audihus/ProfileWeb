<?php 
include "koneksi.php";
$username = $_SESSION["username"];

$sql = "SELECT * FROM user WHERE username='$username'";
$hasil = $conn->query($sql);
$row = $hasil->fetch_assoc();
?>
<div class="container"> 
    <div class="row">
        <div class="table-responsive" id="">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Ganti Password</label>
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="text" class="form-control" name="password" placeholder="Tuliskan Password baru anda">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Ganti Foto Profil</label>
                    <input type="file" class="form-control" name="gambar">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput3" class="form-label">Foto Profil Saat Ini</label>
                    <?php
                    if ($row["foto"] != '') {
                        if (file_exists('img/' . $row["foto"] . '')) {
                    ?>
                            <br><img src="img/<?= $row["foto"] ?>" width="100">
                    <?php
                        }
                    }
                    ?>
                    <input type="hidden" name="gambar_lama" value="<?= $row["foto"] ?>">
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
            </div>
        </form>            
        </div>
    </div>
</div>

<?php
include "upload_foto.php";

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $password = md5($_POST['password']);
    //$username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    //jika ada file yang dikirim  
    if ($nama_gambar != '') {
		    //panggil function upload_foto untuk cek spesifikasi file yg dikirimkan user
		    //function ini memiliki 2 keluaran yaitu status dan message
        $cek_upload = upload_foto($_FILES["gambar"]);

				//cek status true/false
        if ($cek_upload['status']) {
		        //jika true maka message berisi nama file gambar
            $gambar = $cek_upload['message'];
        } else {
		        //jika true maka message berisi pesan error, tampilkan dalam alert
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=profile';
            </script>";
            die;
        }
    }

		//cek apakah ada id yang dikirimkan dari form
    if (isset($_POST['id'])) {
        //jika ada id,    lakukan update data dengan id tersebut
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            //jika tidak ganti gambar
            $gambar = $_POST['gambar_lama'];
        } else {
            //jika ganti gambar, hapus gambar lama
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE user
                                SET 
                                password = ?,
                                foto = ?
                                WHERE id = ?");

        $stmt->bind_param("ssi", $password, $gambar, $id);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=profile';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=profile';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

