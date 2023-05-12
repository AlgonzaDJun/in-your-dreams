<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 5
        });
    });
</script>

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
        <?php
        $no = 1;
        $totalAll = 0;
        $subTotal = 0;
        ?>
        <?php foreach ($data['orderItems'] as $orderItems) { ?>
            <?php
            $subTotal = $orderItems['quantity'] * $orderItems['price'];
            $totalAll += $subTotal;
            ?>
            <tr>
                <input type="hidden" name="items_id" value="<?= $orderItems['order_items_id']; ?>">
                <th scope="row"><?= $no; ?></th>
                <td><?= $orderItems['product_name']; ?></td>
                <td><?= $orderItems['quantity']; ?></td>
                <td><?= number_format($orderItems['price'], 2); ?></td>
                <td><?= number_format($subTotal, 2); ?></td>
                <td><a href="javascript:void(0)" onclick="return hapusOrderItems(<?= $orderItems['order_items_id'] ?>)" class="btn btn-danger">Hapus</a></td>
            </tr>
            <?php
                $no++;
            ?>
        <?php } ?>
    </tbody>
</table>