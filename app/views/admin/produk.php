<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
    });
</script>
<?php
include BASEURL . '/assets/admin/js/js.php';
?>


<div class="container-fluid">
    <div class="w-100 my-3">
        <h1>Produk Anda</h1>
        <button class="btn btn-secondary" onclick="return testToast()">tes toast</button>
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary tampilModalTambah" data-toggle="modal" data-target="#exampleModal">
                Tambah Produk
            </button>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="form" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="id">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama" required>
                        </div>
                        <div id="preview-gambar"></div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                        </div>
                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk</label>
                            <select name="merk" class="custom-select" id="merk" required>
                                <option value="">--Pilih Merk--</option>
                                <?php foreach ($data['merk'] as $merk) { ?>
                                    <option value="<?= $merk['merk_id']; ?>"><?= $merk['merk_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" class="custom-select" id="kategori" required>
                                <option value="">--Pilih Kategori--</option>
                                <?php foreach ($data['kategori'] as $kategori) { ?>
                                    <option value="<?= $kategori['category_id']; ?>"><?= $kategori['category_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status" required>
                                <option value="1">Tersedia</option>
                                <option value="0">Habis</option>
                            </select>
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
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Category</th>
                    <th>Merk</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data['produk'] as $produk) { ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><img src="<?= BASEURL; ?>/img/products/<?= $produk['image']; ?>" width="100px"></td>

                        <td>
                            <?php
                            foreach ($data['kategori'] as $kategori) {
                                if ($kategori['category_id'] == $produk['category_id']) echo $kategori['category_name'];
                            } ?>
                        </td>
                        <td>
                            <?php foreach ($data['merk'] as $merk) {
                                if ($merk['merk_id'] == $produk['merk_id']) echo $merk['merk_name'];
                            } ?>
                        </td>
                        <td><?= $produk['product_name']; ?></td>
                        <td><?php
                            if (strlen($produk['product_desc']) > 30) {
                                echo substr($produk['product_desc'], 0, 30) . '...';
                            } else {
                                echo $produk['product_desc'];
                            } ?>
                        </td>
                        <td><?= $produk['price']; ?></td>
                        <td><?= $produk['stock']; ?></td>
                        <td>
                            <?php $status = $produk['status'] == '1' ? '<i class="fas fa-check-circle fa-lg" style="color: #00a80b;"></i>' : '<i class="fas fa-times-circle fa-lg" style="color: #ff0000;"></i>'; ?>
                            <?= $status; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning tampilModalUbah" data-toggle="modal" data-id="<?= $produk['product_id']; ?>" data-target="#exampleModal" style="margin-bottom: 5px;">Edit</a>
                            <a href="#" class="btn btn-danger" style="margin-bottom: 5px;" onclick="return hapusProduk(<?= $produk['product_id'] ?>)">Hapus</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>