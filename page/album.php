<div class="container">
   <div class="row">
      <div class="col-5">
         <div class="card">
            <div class="card-body">
               <h4 style="font-size: 1rem;">Halaman Album</h4> <!-- Ukuran teks judul lebih kecil -->
               <?php 
               //ambil data yang di kirim oleh <form>
               $submit=@$_POST['submit'];
               $albumID=@$_GET['albumid'];
               if ($submit=='Simpan') {
                  $nama_album=@$_POST['nama_album'];
                  $deskripsi_album=@$_POST['deskripsi_album'];
                  $tanggal=date('Y-m-d');
                  $user_id=@$_SESSION['user_id'];
                  $insert=mysqli_query($conn, "INSERT INTO album VALUES('','$nama_album','$deskripsi_album','$tanggal','$user_id')");
                  if ($insert) {
                     echo '<div class="alert alert-success" role="alert">Berhasil Membuat Album</div>';
                     echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                  }else{
                     echo '<div class="alert alert-danger" role="alert">Gagal Membuat Album</div>';
                     echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                  }
               } elseif (isset($_GET['edit'])) {
                  if ($submit == 'Ubah') {
                     $nama_album = @$_POST['nama_album'];
                     $deskripsi_album = @$_POST['deskripsi_album'];
                     $tanggal = date('Y-m-d');
                     $user_id = @$_SESSION['user_id'];
                     $update = mysqli_query($conn, "UPDATE album SET NamaAlbum='$nama_album', Deskripsi='$deskripsi_album' WHERE AlbumID='$albumID'");
                     if ($update) {
                        echo '<div class="alert alert-success" role="alert">Berhasil Mengubah Album</div>';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                     } else {
                        echo '<div class="alert alert-danger" role="alert">Gagal Mengubah Album</div>';
                        echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                     }
                  }
               } elseif (isset($_GET['hapus'])) {
                  $hapus = mysqli_query($conn, "DELETE FROM album WHERE AlbumID='$albumID'");
                  if ($hapus) {
                     echo '<div class="alert alert-success" role="alert">Berhasil Hapus Album</div>';
                     echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                  } else {
                     echo '<div class="alert alert-danger" role="alert">Gagal Hapus Album</div>';
                     echo '<meta http-equiv="refresh" content="0.8; url=?url=album">';
                  }
               }
               $val = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM album WHERE AlbumID='$albumID' "));
               ?>
               <?php if (!isset($_GET['edit'])): ?>
               <form action="?url=album" method="post">
                  <div class="form-group">
                     <label>Nama Album</label>
                     <input type="text" class="form-control" required name="nama_album" placeholder="Masukkan Nama Album">
                  </div>
                  <div class="form-group">
                     <label>Deskripsi Album</label>
                     <textarea name="deskripsi_album" class="form-control" required cols="30" rows="5" placeholder="Masukkan Deskripsi Album"></textarea>
                  </div>
                  <input type="submit" value="Simpan" name="submit" class="btn btn-danger btn-sm my-3"> <!-- Gunakan btn-sm -->
               </form>
               <?php elseif (isset($_GET['edit'])): ?>
               <form action="?url=album&edit&albumid=<?= $val['AlbumID'] ?>" method="post">
                  <div class="form-group">
                     <label>Nama Album</label>
                     <input type="text" class="form-control" value="<?= $val['NamaAlbum'] ?>" required name="nama_album" placeholder="Masukkan Nama Album">
                  </div>
                  <div class="form-group">
                     <label>Deskripsi Album</label>
                     <textarea name="deskripsi_album" class="form-control" required cols="30" rows="5" placeholder="Masukkan Deskripsi Album"><?= $val['Deskripsi'] ?></textarea>
                  </div>
                  <input type="submit" value="Ubah" name="submit" class="btn btn-danger btn-sm my-3"> <!-- Gunakan btn-sm -->
               </form>
               <?php endif; ?>
            </div>
         </div>
      </div>
      <div class="col-7">
         <div class="card">
            <div class="card-body">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Nama Album</th>
                        <th>Deskripsi Album</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $i = 1;
                     $userid = @$_SESSION['user_id'];
                     $albums = mysqli_query($conn, "SELECT * FROM album WHERE UserID='$userid'");
                     foreach ($albums as $album):
                     ?>
                     <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $album['NamaAlbum'] ?></td>
                        <td><?= $album['Deskripsi'] ?></td>
                        <td><?= $album['TanggalDibuat'] ?></td>
                        <td>
                           <a href="?url=album&edit&albumid=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                           <a href="?url=album&hapus&albumid=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
