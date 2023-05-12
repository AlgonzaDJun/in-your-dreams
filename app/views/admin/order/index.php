<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
        $('#dataTable2').DataTable({
            "pageLength": 5
        });
    });
</script>

<?php
include BASEURL . '/assets/admin/js/js_order.php';
?>

<div class="container-fluid">
    <div class="w-100 my-3">
        <h1>Order</h1>
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary" onclick="changeContent('addOrder')">
                Tambah Order
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="form" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" id="order_id" value="id">
                        <div class="mb-3">
                            <label for="pemesan" class="form-label">Nama Pemesan</label>
                            <input readonly type="text" class="form-control" id="pemesan" name="pemesan" required>
                        </div>
                        <!-- harga total, kode voucher, after diskon, metode pembayaran, status, alamat, tanggal order -->
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Harga Total</label>
                            <input readonly type="text" class="form-control" id="total_price" name="total_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="kode_voucher" class="form-label">Kode Voucher</label>
                            <input readonly type="text" class="form-control" id="kode_voucher" name="kode_voucher" required>
                        </div>
                        <div class="mb-3">
                            <label for="after_diskon" class="form-label">After Diskon</label>
                            <input readonly type="text" class="form-control" id="after_diskon" name="after_diskon" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select class="custom-select" name="payment_method" id="payment_method" required>
                                <option value="1">Cash</option>
                                <option value="2">Transfer Bank</option>
                                <option value="3">E-Money</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="custom-select" name="status" id="status" required>
                                <option value="0">Belum Bayar</option>
                                <option value="1">Sudah Bayar</option>
                                <option value="2">Diantar</option>
                                <option value="3">Diterima</option>
                                <option value="4">Selesai</option>
                                <option value="5">Batal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-start justify-content-between">
                                <label for="alamat" class="form-label">Alamat</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="return ubahAlamat()">Ubah Alamat</button>
                            </div>
                            <textarea class="form-control" name="alamat" id="alamat" rows="2">alamat</textarea>
                        </div>
                        <div class="table-responsive" id="order_items">
                            <table class="table table-striped table-bordered" id="dataTable2">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Quantitas</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
                    <th>ID</th>
                    <th>Pemesan</th>
                    <th>Harga Total (Rp)</th>
                    <th>Kode Voucher</th>
                    <th>After Diskon</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Order</th>
                    <th>Alamat Pengiriman</th>
                    <th>Tanggal Order</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data['order'] as $order) { ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $order['nama_lengkap']; ?></td>
                        <td>
                            <?= number_format($order['hrg_total'], 2); ?>
                        </td>
                        <td>
                            <?= $order['code']; ?>
                        </td>
                        <td><?= number_format($order['after_discount'], 2); ?></td>
                        <td>
                            <?php
                            $payment_method = $order['payment_method'] == '1' ? 'CASH' : ($order['payment_method'] == '2' ? 'TRANSFER BANK' : 'E-MONEY');
                            echo $payment_method;
                            ?>
                        </td>
                        <td>
                            <?php $status = $order['status'] == '0' ? 'Belum Bayar' : ($order['status'] == '1' ? 'Sudah Bayar' : ($order['status'] == '2' ? 'Diantar' : ($order['status'] == '3' ? 'Diterima' : ($order['status'] == '4' ? 'Selesai' : 'Batal'))));
                            echo $status; ?>
                        </td>
                        <td><?php
                            if (strlen($order['alamat']) > 30) {
                                echo substr($order['alamat'], 0, 30) . '...';
                            } else {
                                echo $order['alamat'];
                            } ?>
                        </td>
                        <td>
                            <?php $phpdate = strtotime($order['created_at']);
                            $mysqldate = date('d-M-Y', $phpdate); ?>
                            <?= $mysqldate ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-success tampilModalUbah" style="width: 90px;" data-toggle="modal" data-id="<?= $order['order_id']; ?>" data-target="#exampleModal" style="margin-bottom: 5px;"><i class="fas fa-edit"></i>Detail</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- <form>
        <label for="input-angka">Masukkan angka:</label>
        <input type="number" id="input-angka" name="input-angka">
        <br>
        <input type="number" id="input-angka2" name="input-angka2" value="2"/>
        <br>
        <label for="output-angka">Hasil format:</label>
        <span id="output-angka"></span>
    </form> -->
</div>