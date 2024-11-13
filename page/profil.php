<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <h2>Halaman Profile</h2>
                    <?php
                    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE UserID='{$_SESSION['user_id']}'"));
                    if (isset($_POST['editprofile'])) {
                        $nama = $_POST['nama'];
                        $email = $_POST['email'];
                        $username = $_POST['username'];
                        $alamat = $_POST['alamat'];
                        $alert = '';
                        if (isset($username) && isset($email)) {
                            if ($username == $user['Username'] && $email == $user['Email'] && $alamat == $user['Alamat']) {
                                $ubah = mysqli_query($conn, "UPDATE user SET NamaLengkap='$nama' WHERE UserID='$_SESSION[user_id]'");
                                $alert = $ubah ? 'Ubah nama berhasil' : 'Ubah nama gagal';
                                if ($ubah) {
                                    $_SESSION['namalengkap'] = $nama;
                                }
                            } else if ($username == $user['Username'] && $email == $user['Email'] && $nama == $user['NamaLengkap']) {
                                $ubah = mysqli_query($conn, "UPDATE user SET Alamat='$alamat' WHERE UserID='$_SESSION[user_id]'");
                                $alert = $ubah ? 'Ubah alamat berhasil' : 'Ubah alamat gagal';
                            } else if ($username == $user['Username'] && $alamat == $user['Alamat'] && $nama == $user['NamaLengkap']) {
                                $ubah = mysqli_query($conn, "UPDATE user SET Email='$email' WHERE UserID='$_SESSION[user_id]'");
                                $alert = $ubah ? 'Ubah email berhasil' : 'Ubah email gagal';
                                if ($ubah) {
                                    $_SESSION['email'] = $email;
                                }
                            } else if ($email == $user['Email'] && $alamat == $user['Alamat'] && $nama == $user['NamaLengkap']) {
                                $ubah = mysqli_query($conn, "UPDATE user SET Username='$username' WHERE UserID='$_SESSION[user_id]'");
                                $alert = $ubah ? 'Ubah username berhasil' : 'Ubah username gagal';
                                if ($ubah) {
                                    $_SESSION['username'] = $username;
                                }
                            }
                        }
                    } else if (isset($_POST['editpassword'])) {
                        $password = md5($_POST['password']);
                        if ($password != $user['Password']) {
                            $ubah = mysqli_query($conn, "UPDATE user SET Password='$password' WHERE UserID='$_SESSION[user_id]'");
                            $alert = $ubah ? 'Ubah password berhasil' : 'Ubah password gagal';
                        }
                    }
                    ?>
                    <script>
                        // Jika ada alert, tampilkan popup
                        <?php if (!empty($alert)) : ?>
                            alert("<?= $alert ?>");
                            setTimeout(function() {
                                window.location.href = "?url=profile";
                            }, 0); // Mengalihkan setelah 2 detik
                        <?php endif; ?>
                    </script>

                    <?php if (@$_GET['proses'] == 'editprofile') : ?>
                        <form action="?url=profile&&proses=editprofile" method="post">
                            <div class="input-group mb-3">
                                <label for="nama" class="input-group-text"><i class="fa-solid fa-circle-user fa-fw fa-lg"></i></label>
                                <input type="text" class="form-control" value="<?= $user['NamaLengkap'] ?>" id="nama" name="nama" required placeholder="Masukan Nama Lengkap">
                            </div>
                            <div class="input-group mb-3">
                                <label for="email" class="input-group-text"><i class="fa-solid fa-envelope fa-fw fa-lg"></i></label>
                                <input type="email" class="form-control" value="<?= $user['Email'] ?>" id="email" name="email" required placeholder="Masukan Email Anda">
                            </div>
                            <div class="input-group mb-3">
                                <label for="username" class="input-group-text"><i class="fa-solid fa-at fa-fw fa-lg"></i></label>
                                <input type="text" class="form-control" value="<?= $user['Username'] ?>" id="username" name="username" required placeholder="Masukan Username">
                            </div>
                            <div class="input-group mb-4">
                                <label for="alamat" class="input-group-text"><i class="fa-solid fa-address-book fa-fw fa-lg"></i></label>
                                <input type="text" class="form-control" id="alamat" value="<?= $user['Alamat'] ?>" name="alamat" required placeholder="Masukan Alamat Lengkap">
                            </div>
                            <a href="?url=profile" class="btn btn-dark fw-semibold btn-sm">Kembali</a>
                            <input type="submit" value="Simpan Perubahan" name="editprofile" class="btn btn-primary fw-semibold btn-sm">
                        </form>
                    <?php elseif (@$_GET['proses'] == 'editpassword') : ?>
                        <form action="?url=profile&&proses=editpassword" method="post">
                            <div class="input-group mb-4">
                                <label for="password" class="input-group-text"><i class="fa-solid fa-lock fa-fw fa-lg"></i></label>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukan Password Baru">
                            </div>
                            <a href="?url=profile" class="btn btn-dark fw-semibold btn-sm">Kembali</a>
                            <input type="submit" value="Simpan Perubahan" name="editpassword" class="btn btn-primary fw-semibold btn-sm">
                        </form>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-white table-hover">
                                <tr>
                                    <th style="width: 20%;" class="py-3">Nama Lengkap</th>
                                    <td class="py-3 text-muted"><?= $user['NamaLengkap'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="py-3">Email</th>
                                    <td class="py-3 text-muted"><?= $user['Email'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="py-3">Username</th>
                                    <td class="py-3 text-muted"><?= $user['Username'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;" class="py-3">Alamat</th>
                                    <td class="py-3 text-muted"><?= $user['Alamat'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <a href="?url=profile&&proses=editprofile" class="btn btn-danger btn-sm">Edit Profil</a>
                        <a href="?url=profile&&proses=editpassword" class="btn btn-primary btn-sm">Edit Password</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
