<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
    });
</script>
<?php
include BASEURL . '/assets/admin/js/js_voucher.php';
?>

<div class="container-fluid">
    <div class="w-100 my-3">
        <h1>Voucher</h1>
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary tampilModalTambah" data-toggle="modal" data-target="#exampleModal">
                Tambah Voucher
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Voucher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="form" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="id">
                        <div class="mb-3">
                            <label for="kode_voucher" class="form-label">Kode Voucher</label>
                            <input autocomplete="off" type="text" class="form-control" id="kode_voucher" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Diskon (Rp.)</label>
                            <input type="number" class="form-control" id="discount" name="discount" rows="3" required></input>
                        </div>
                        <!-- startdate use datepicker -->
                        <div class="mb-3">
                            <label for="startdate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startdate" name="startdate" required>
                        </div>
                        <!-- enddate use datepicker -->
                        <div class="mb-3">
                            <label for="enddate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="enddate" name="enddate" required>
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
                    <th>Kode Voucher</th>
                    <th>Diskon</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data['voucher'] as $voucher) { ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $voucher['code']; ?></td>
                        <td><?= $voucher['discount']; ?></td>
                        <td>
                            <div class="form-control">
                                <?= date('d-M-Y', strtotime($voucher['startdate'])); ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-control">
                                <?= date('d-M-Y', strtotime($voucher['enddate'])); ?>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning tampilModalUbah" data-toggle="modal" data-id="<?= $voucher['voucher_id']; ?>" data-target="#exampleModal" style="margin-bottom: 5px;">Edit</a>
                            <a href="#" class="btn btn-danger" style="margin-bottom: 5px;" onclick="return hapusVoucher(<?= $voucher['voucher_id'] ?>)">Hapus</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>