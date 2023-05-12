<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
    });
</script>
<?php
include BASEURL . '/assets/admin/js/js_user.php';
?>

<div class="container-fluid">
    <!-- ini halaman kategori -->
    <div class="w-100 my-3">
        <h1>User</h1>
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary tampilModalTambah" data-toggle="modal" data-target="#exampleModal">
                Tambah User
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="form" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="id">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <!-- username, password, nmr_telp, alamat, email -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="nmr_telp" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control" id="nmr_telp" name="nmr_telp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" id="submit-button" class="btn btn-primary" data-dismiss="modal" onclick="return submitForm()">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data['user'] as $user) { ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $user['nama_lengkap']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= substr($user['password'], 0, 10) . '***'; ?></td>
                        <td><?= $user['nmr_telp']; ?></td>
                        <td><?= $user['alamat']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td>
                            <a href="#" class="btn btn-warning tampilModalUbah" data-toggle="modal" data-id="<?= $user['user_id']; ?>" data-target="#exampleModal" style="margin-bottom: 5px;">Edit</a>
                            <a href="#" class="btn btn-danger" style="margin-bottom: 5px;" onclick="return hapusUser(<?= $user['user_id'] ?>)">Hapus</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>