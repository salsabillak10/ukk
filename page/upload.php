<div class="container">
    <div class="row">
        <div class="col-lg-5 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="font-size: 1rem;">Halaman Upload</h4>
                    <?php
                    // Ambil data dari <form>
                    $submit = @$_POST['submit'];
                    $fotoid = @$_GET['fotoid'];
                    if ($submit == 'Simpan') {
                        $judul_foto = @$_POST['judul_foto'];
                        $deskripsi_foto = @$_POST['deskripsi_foto'];
                        $nama_file = @$_FILES['namafile']['name'];
                        $tmp_foto = @$_FILES['namafile']['tmp_name'];
                        $tanggal = date('Y-m-d');
                        $album_id = @$_POST['album_id'];
                        $user_id = @$_SESSION['user_id'];
                        if (move_uploaded_file($tmp_foto, 'uploads/' . $nama_file)) {
                            $insert = mysqli_query($conn, "INSERT INTO foto VALUES('','$judul_foto','$deskripsi_foto','$tanggal','$nama_file','$album_id','$user_id')");
                            echo '<div class="alert alert-success" style="font-size: 0.875rem;">Gambar Berhasil disimpan</div>';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                        } else {
                            echo '<div class="alert alert-danger" style="font-size: 0.875rem;">Gambar gagal disimpan</div>';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                        }
                    } elseif (isset($_GET['edit'])) {
                        if ($submit == 'Ubah') {
                            $judul_foto = @$_POST['judul_foto'];
                            $deskripsi_foto = @$_POST['deskripsi_foto'];
                            $nama_file = @$_FILES['namafile']['name'];
                            $tmp_foto = @$_FILES['namafile']['tmp_name'];
                            $tanggal = date('Y-m-d');
                            $album_id = @$_POST['album_id'];
                            $user_id = @$_SESSION['user_id'];
                            if (strlen($nama_file) == 0) {
                                $update = mysqli_query($conn, "UPDATE foto SET JudulFoto='$judul_foto', DeskripsiFoto='$deskripsi_foto', TanggalUnggah='$tanggal', AlbumID='$album_id' WHERE FotoID='$fotoid'");
                                if ($update) {
                                    echo '<div class="alert alert-success" style="font-size: 0.875rem;">Gambar Berhasil diubah</div>';
                                    echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                                } else {
                                    echo '<div class="alert alert-danger" style="font-size: 0.875rem;">Gambar gagal diubah</div>';
                                    echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                                }
                            } else {
                                if (move_uploaded_file($tmp_foto, "uploads/" . $nama_file)) {
                                    $update = mysqli_query($conn, "UPDATE foto SET JudulFoto='$judul_foto', DeskripsiFoto='$deskripsi_foto', NamaFile='$nama_file', TanggalUnggah='$tanggal', AlbumID='$album_id' WHERE FotoID='$fotoid'");
                                    if ($update) {
                                        echo '<div class="alert alert-success" style="font-size: 0.875rem;">Gambar Berhasil diubah</div>';
                                        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                                    } else {
                                        echo '<div class="alert alert-danger" style="font-size: 0.875rem;">Gambar gagal diubah</div>';
                                        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                                    }
                                }
                            }
                        }
                    } elseif (isset($_GET['hapus'])) {
                        $delete = mysqli_query($conn, "DELETE FROM foto WHERE FotoID='$fotoid'");
                        if ($delete) {
                            echo '<div class="alert alert-success" style="font-size: 0.875rem;">Gambar Berhasil dihapus</div>';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                        } else {
                            echo '<div class="alert alert-danger" style="font-size: 0.875rem;">Gambar gagal dihapus</div>';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
                        }
                    }
                    // Mencari data album
                    $album = mysqli_query($conn, "SELECT * FROM album WHERE UserID='$_SESSION[user_id]'");
                    $val = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM foto WHERE FotoID='$fotoid'"));
                    ?>
                    <?php if (!isset($_GET['edit'])) : ?>
                        <form action="?url=upload" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul Foto</label>
                                <input type="text" class="form-control" required name="judul_foto" style="font-size: 0.875rem;">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Foto</label>
                                <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5" style="font-size: 0.875rem;"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" name="namafile" class="form-control" required>
                                <small class="text-danger" style="font-size: 0.875rem;">File Harus Berupa: *.jpg, *.png *.gif</small>
                            </div>
                            <div class="form-group">
                                <label>Pilih Album</label>
                                <select name="album_id" class="form-select" style="font-size: 0.875rem;">
                                    <?php foreach ($album as $albums) : ?>
                                        <option value="<?= $albums['AlbumID'] ?>"><?= $albums['NamaAlbum'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="submit" value="Simpan" name="submit" class="btn btn-primary btn-sm my-3">
                        </form>
                    <?php elseif (isset($_GET['edit'])) : ?>
                        <form action="?url=upload&&edit&&fotoid=<?= $val['FotoID'] ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul Foto</label>
                                <input type="text" class="form-control" value="<?= $val['JudulFoto'] ?>" required name="judul_foto" style="font-size: 0.875rem;">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Foto</label>
                                <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5" style="font-size: 0.875rem;"><?= $val['DeskripsiFoto'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" name="namafile" class="form-control">
                                <small class="text-danger" style="font-size: 0.875rem;">File Harus Berupa: *.jpg, *.png *.gif</small>
                            </div>
                            <div class="form-group">
                                <label>Pilih Album</label>
                                <select name="album_id" class="form-select" style="font-size: 0.875rem;">
                                    <?php foreach ($album as $albums) : ?>
                                        <option value="<?= $albums['AlbumID'] ?>" <?= $albums['AlbumID'] == $val['AlbumID'] ? 'selected' : '' ?>><?= $albums['NamaAlbum'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="submit" value="Ubah" name="submit" class="btn btn-warning btn-sm my-3">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <div class="row">
                <?php
                $fotos = mysqli_query($conn, "SELECT * FROM foto WHERE UserID='" . @$_SESSION['user_id'] . "'");
                foreach ($fotos as $foto) :
                ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="card" style="width: 110%;"> <!-- Menambahkan style width -->
                            <img src="uploads/<?= $foto['LokasiFile'] ?>" class="card-img-top object-fit-cover" style="aspect-ratio: 16/9; height: 150px;"> <!-- Mengubah tinggi -->
                            <div class="card-body">
                                <p class="small" style="font-size: 0.875rem;"><?= $foto['JudulFoto'] ?></p>
                                <a href="?url=upload&&edit&fotoid=<?= $foto['FotoID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?url=upload&&hapus&fotoid=<?= $foto['FotoID'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
