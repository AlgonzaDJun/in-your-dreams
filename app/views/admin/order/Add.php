<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
    });
</script>
<?php
include BASEURL . '/assets/admin/js/js_order.php';
?>

<div class="container-fluid">
    <!-- ini halaman kategori -->
    <div class="w-100 my-3">
        <h1>Tambah Order</h1>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <!-- form user info -->
            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0">Pilih detail order</h3>
                </div>
                <div class="card-body">
                    <form id="form" autocomplete="off" class="form" role="form">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Pemesan</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="pemesan" id="pemesan" size="0">
                                    <option value="0">Pilih Pemesan</option>
                                    <?php foreach ($data['user'] as $user) : ?>
                                        <option value="<?= $user['user_id']; ?>"><?= $user['nama_lengkap']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Voucher</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="voucher" id="voucher" size="0">
                                    <option value="0">Pilih Voucher</option>
                                    <?php foreach ($data['voucher'] as $voucher) : ?>
                                        <option value="<?= $voucher['voucher_id']; ?>"><?= $voucher['code'] . " (Potongan Rp." . $voucher['discount'] . ") "; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Metode Pembayaran</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="payment_method" id="payment_method" size="0">
                                    <option value="">Pilih Metode</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Transfer Bank</option>
                                    <option value="3">E-Money</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Status Order</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="status" id="status" size="0">
                                    <option value="">Pilih Status</option>
                                    <option value="0">Belum Bayar</option>
                                    <option value="1">Sudah Bayar</option>
                                    <option value="2">Diantar</option>
                                    <option value="3">Diterima</option>
                                    <option value="4">Selesai</option>
                                    <option value="5">Batal</option>
                                </select>
                            </div>
                        </div>
                        <!--  alamat -->
                        <div class="form-group row">
                            <label class="col-lg-6 col-form-label form-control-label">Alamat Order</label>
                            <!-- textarea -->
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label form-control-label">Pilih Product</label>
                            <div class="col-lg-6">
                                <select class="form-control" name="product" id="product" size="0">
                                    <option value="">Pilih product</option>
                                    <?php foreach ($data['produk'] as $produk) : ?>
                                        <option value="<?= $produk['product_id']; ?>" data-price="<?= $produk['price']; ?>"><?= $produk['product_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" type="number" value="1" id="quantity" name="quantity">
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="">
                                <a onclick="return tambahProdukOrder()" href="javascript:void(0)" class="btn btn-primary">tambah produk</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /form user info -->
        <div class="col-sm-12 col-md-6">
            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0">Detail Produk Order</h3>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="table-responsive" id="ubahTable">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Quantitas</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 row justify-content-end">
                    <button class="btn btn-primary" onclick="return tambahOrder()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>