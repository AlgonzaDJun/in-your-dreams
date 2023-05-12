<?php

$product = new Produk();

?>


<div class="container" style="margin-top: 100px;">
    <h2>Ini adalah Daftar semua produk</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga Produk</th>
                <th scope="col">Jumlah Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $products = $product->getAllProducts();

            foreach ($products as $produk) {
            ?>
                <tr>
                    <th scope="row"><?= $no; ?></th>
                    <td><?= $produk['product_name']; ?></td>
                    <td><?= $produk['price']; ?></td>
                    <td><?= $produk['stock']; ?></td>
                </tr>
            <?php
                $no++;
            } ?>
        </tbody>
    </table>

    <?php if (isset($_GET['id'])) { ?>
        <p>Detail produk dengan id <?= $_GET['id']; ?></p>
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Produk <?= $_GET['id']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ini adalah produk dengan ID <?= $_GET['id']; ?>.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
    myModal.toggle()
</script>