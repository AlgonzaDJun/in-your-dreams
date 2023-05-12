<?php

class Order_model
{
    private $tabel = 'orders';
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAllOrder()
    {
        $query = "SELECT a.*, b.nama_lengkap, IFNULL(c.code, 'no diskon') as code, a.hrg_total - IFNULL(c.discount,0) as after_discount FROM `orders` a LEFT JOIN USER b ON a.user_id = b.user_id LEFT JOIN voucher c ON a.voucher_id = c.voucher_id";
        $this->conn->query($query);
        $allOrder = $this->conn->resultSet();
        return $allOrder;
    }

    public function getOrdersTemp($id)
    {
        $query = "SELECT a.order_temp_id, a.user_id, b.product_name, a.quantity, a.price FROM `order_items_temp` a LEFT JOIN products b ON a.product_id = b.product_id WHERE `user_id` = $id";
        $this->conn->query($query);
        $ordersTemp = $this->conn->resultSet();
        return $ordersTemp;
    }

    public function cekDuplikat()
    {
        $query = "SELECT * FROM `order_items_temp` WHERE `user_id` = :user_id AND `product_id` = :product_id";
        $this->conn->query($query);
        $this->conn->bind('user_id', $_POST['pemesan']);
        $this->conn->bind('product_id', $_POST['product']);
        $this->conn->execute();
        return $this->conn->resultSet();
    }

    public function tambahOrderTemp()
    {
        $query = "INSERT INTO `order_items_temp` (`order_temp_id`, `user_id`, `product_id`, `quantity`, `price`) VALUES ('', :user_id, :product_id, :quantity, :price)";

        $queryUpdate = "UPDATE `order_items_temp` SET `quantity` = :quantity WHERE `order_items_temp`.`user_id` = :user_id AND `order_items_temp`.`product_id` = :product_id";

        $duplikat = $this->cekDuplikat();
        $updateQuantity = $_POST['quantity'] + $duplikat[0]['quantity'];

        if ($duplikat) {
            $this->conn->query($queryUpdate);
            $this->conn->bind('user_id', $_POST['pemesan']);
            $this->conn->bind('product_id', $_POST['product']);
            $this->conn->bind('quantity', $updateQuantity);
            $this->conn->execute();
        } else {
            $this->conn->query($query);
            $this->conn->bind('user_id', $_POST['pemesan']);
            $this->conn->bind('product_id', $_POST['product']);
            $this->conn->bind('quantity', $_POST['quantity']);
            $this->conn->bind('price', $_POST['price']);
            $this->conn->execute();
        }
        return $this->conn->rowCount();
    }

    public function tambahOrder($data)
    {
        // tambahkan ke tabel orders terlebih dahulu lalu ambil id nya
        $query = "INSERT INTO orders VALUES ('', :user_id, :voucher_id, :hrg_total, :status_ord, :alamat, :payment_method, NOW(), NOW())";
        $this->conn->query($query);
        $this->conn->bind('user_id', $data['pemesan']);
        $this->conn->bind('voucher_id', $data['voucher']);
        $this->conn->bind('hrg_total', $data['total_price']);
        $this->conn->bind('status_ord', $data['status']);
        $this->conn->bind('alamat', $data['alamat']);
        $this->conn->bind('payment_method', $data['payment_method']);
        $this->conn->execute();
        $lastId = $this->conn->lastInsertId();

        // var_dump($data);

        echo 'last id: ' . $lastId . '';

        // var_dump($data);

        $search = "select * from order_items_temp where user_id = :user_id";
        $this->conn->query($search);
        $this->conn->bind('user_id', $data['pemesan']);
        $this->conn->execute();
        $order_items = $this->conn->resultSet();


        // insert ke tabel order_items
        foreach ($order_items as $item) {
            $query2 = "INSERT INTO order_items VALUES ('', :order_id, :product_id, :quantity, :price)";
            $this->conn->query($query2);
            $this->conn->bind('order_id', $lastId);
            $this->conn->bind('product_id', $item['product_id']);
            $this->conn->bind('quantity', $item['quantity']);
            $this->conn->bind('price', $item['price']);
            $this->conn->execute();
        }

        // hapus data di tabel order_items_temp
        $query3 = "DELETE FROM `order_items_temp` WHERE `user_id` = :user_id";
        $this->conn->query($query3);
        $this->conn->bind('user_id', $_POST['pemesan']);
        $this->conn->execute();

        return $this->conn->rowCount();
    }

    public function tambahOrderItems($data)
    {
        $order_items = json_decode($data['order_items'], true);
        var_dump($order_items);
    }

    public function hapusOrderTemp()
    {
        $query = "DELETE FROM `order_items_temp` WHERE order_temp_id = :order_temp_id";
        $this->conn->query($query);
        $this->conn->bind('order_temp_id', $_POST['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function getOrderById($id)
    {
        $query = "SELECT a.*, b.nama_lengkap, IFNULL(c.code, 'no diskon') as code, a.hrg_total - IFNULL(c.discount,0) as after_discount FROM `orders` a LEFT JOIN USER b ON a.user_id = b.user_id LEFT JOIN voucher c ON a.voucher_id = c.voucher_id where a.order_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $id);
        return $this->conn->single();
    }

    public function getOrdersItems($id)
    {
        $query = "SELECT a.*, b.product_name FROM `order_items` a LEFT JOIN products b ON a.product_id = b.product_id WHERE `order_id` = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $id);
        return $this->conn->resultSet();
    }

    public function ubahStatus($data)
    {
        $query = "UPDATE `orders` SET `status` = :status_ord WHERE `orders`.`order_id` = :order_id";
        $this->conn->query($query);
        $this->conn->bind('status_ord', $data['status']);
        $this->conn->bind('order_id', $data['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function ubahMetodePembayaran($data)
    {
        $query = "UPDATE `orders` SET `payment_method` = :payment_method WHERE `orders`.`order_id` = :order_id";
        $this->conn->query($query);
        $this->conn->bind('payment_method', $data['payment_method']);
        $this->conn->bind('order_id', $data['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function ubahAlamat($data)
    {
        $query = "UPDATE `orders` SET `alamat` = :alamat WHERE `orders`.`order_id` = :order_id";
        $this->conn->query($query);
        $this->conn->bind('alamat', $data['alamat']);
        $this->conn->bind('order_id', $data['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function hapusOrderItems($data)
    {
        $query = "DELETE FROM `order_items` WHERE `order_items_id` = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $data['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }
}
