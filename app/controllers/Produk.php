<?php

class Produk extends Controller
{
    public function index()
    {
        $data['produk'] = $this->model('Produk_model')->getAllProducts();
        $this->view('admin/produk', $data);
    }

    public function tambahProduk()
    {
        if ($this->model('Produk_model')->tambahProduk($_POST) > 0) {
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
        // var_dump($_POST);
        // die;
    }

    public function hapusProduk()
    {
        if ($this->model('Produk_model')->hapusProduk($_POST) > 0) {
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
        // var_dump($_POST);
        // die;
    }

    public function getProdukById()
    {
        echo json_encode($this->model('Produk_model')->getProdukById($_POST['id']));
    }

    public function ubahProduk()
    {
        if ($this->model('Produk_model')->ubahProduk($_POST) > 0) {
            echo "<script>
                    alert('Produk berhasil diubah!');
                </script>";
            // Flasher::setFlash('Produk Berhasil ', 'ditambahkan', 'success');
            exit;
        } else {
            // echo "<script>
            //         alert('Produk gagal diubah!');
            //     </script>";
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
            // Flasher::setFlash('Produk Gagal', ' ditambahkan', 'error');
            exit;
        }
    }
}
