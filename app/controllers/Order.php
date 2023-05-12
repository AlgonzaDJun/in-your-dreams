<?php

class Order extends Controller
{
    public function index()
    {
        $data['order'] = $this->model('Order_model')->getAllOrder();
        $this->view('admin/order/index', $data);
    }

    public function addOrder()
    {
        $this->view('admin/order/add');
    }

    public function getOrderById()
    {
        echo json_encode($this->model('Order_model')->getOrderById($_POST['id']));
    }

    public function getOrdersItems($id)
    {
        if ($this->model('Order_model')->getOrdersItems($id) < 0) {
            echo "<tr>
                    <td colspan='5' class='text-center'>Tidak ada produk</td>
                </tr>";
        } else {
            $data['orderItems'] = $this->model('Order_model')->getOrdersItems($id);
            $this->view('admin/order/ordersItemsTable', $data);
        }
    }

    public function getOrdersTemp($id)
    {
        $data['orderTemp'] = $this->model('Order_model')->getOrdersTemp($id);
        $this->view('admin/order/ordersTempTable', $data);
    }

    public function tambahOrderTemp()
    {
        if ($this->model('Order_model')->tambahOrderTemp($_POST) > 0) {
            echo "<script>
                    alert('Produk berhasil ditambahkan!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Produk gagal ditambahkan!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function hapusOrderTemp()
    {
        if ($this->model('Order_model')->hapusOrderTemp($_POST) > 0) {
            echo "<script>
                    alert('Produk berhasil dihapus!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Produk gagal dihapus!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function tambahOrder()
    {
        if ($this->model('Order_model')->tambahOrder($_POST) > 0) {
            echo "<script>
                    alert('Order berhasil ditambahkan!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Order gagal ditambahkan!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function tambahOrderItems()
    {
        if ($this->model('Order_model')->tambahOrderItems($_POST) > 0) {
            echo "<script>
                    alert('Order berhasil ditambahkan!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Order gagal ditambahkan!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function ubahStatus()
    {
        if ($this->model('Order_model')->ubahStatus($_POST) > 0) {
            echo "<script>
                    alert('Status berhasil diubah!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Status gagal diubah!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function ubahMetodePembayaran()
    {
        if ($this->model('Order_model')->ubahMetodePembayaran($_POST) > 0) {
            echo "<script>
                    alert('Metode Pembayaran berhasil diubah!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Metode Pembayaran gagal diubah!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function ubahAlamat()
    {
        if ($this->model('Order_model')->ubahAlamat($_POST) > 0) {
            echo "<script>
                    alert('Alamat berhasil diubah!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Alamat gagal diubah!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }

    public function hapusOrderItems()
    {
        if ($this->model('Order_model')->hapusOrderItems($_POST) > 0) {
            echo "<script>
                    alert('Order berhasil dihapus!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            echo "<script>
                    alert('Order gagal dihapus!');
                </script>";
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }
}
