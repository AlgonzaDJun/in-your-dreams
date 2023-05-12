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
        ?>
        <?php foreach ($data['orderTemp'] as $orderTemp) { ?>
            <?php
            $subTotal = $orderTemp['quantity'] * $orderTemp['price'];
            $totalAll += $subTotal;
            ?>
            <tr>
                <input type="hidden" name="id" value="<?= $orderTemp['order_temp_id']; ?>">
                <th scope="row"><?= $no; ?></th>
                <td><?= $orderTemp['product_name']; ?></td>
                <td><?= $orderTemp['quantity']; ?></td>
                <td><?= number_format($orderTemp['price'],2); ?></td>
                <td><?= number_format($subTotal,2); ?></td>
                <td><a href="javascript:void(0)" onclick="return hapusOrderTemp(<?= $orderTemp['order_temp_id'] ?>)" class="btn btn-danger">Hapus</a></td>
            </tr>
            <?php
            $no++;
            ?>
        <?php } ?>
        <tr>
            <td>Total Order</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= number_format($totalAll, 2); ?></td>
            <td></td>
            <input type="hidden" name="total_price" value="<?= $totalAll; ?>">
        </tr>
    </tbody>
</table>