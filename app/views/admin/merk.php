<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
    });
</script>
<?php
include BASEURL . '/assets/admin/js/js_merk.php';
?>

<div class="container-fluid">
    <div class="w-100 my-3">
        <h1>Merk</h1>
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary tampilModalTambah" data-toggle="modal" data-target="#exampleModal">
                Tambah Merk
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah merk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="form" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="id">
                        <div class="mb-3">
                            <label for="nama_merk" class="form-label">Nama merk</label>
                            <input type="text" class="form-control" id="nama_merk" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
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
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data['merk'] as $merk) { ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $merk['merk_name']; ?></td>
                        <td><?= $merk['merk_desc']; ?></td>
                        <td>
                            <a href="#" class="btn btn-warning tampilModalUbah" data-toggle="modal" data-id="<?= $merk['merk_id']; ?>" data-target="#exampleModal" style="margin-bottom: 5px;">Edit</a>
                            <a href="#" class="btn btn-danger" style="margin-bottom: 5px;" onclick="return hapusMerk(<?= $merk['merk_id'] ?>)">Hapus</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>