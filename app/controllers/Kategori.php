<?php

class Kategori extends Controller
{
    public function index()
    {
        $data['kategori'] = $this->model('Kategori_model')->getAllKategori();
        $this->view('admin/kategori', $data);
    }

    public function tambahKategori()
    {
        if ($this->model('Kategori_model')->tambahKategori($_POST) > 0) {
            echo "<script>
                    alert('Kategori berhasil ditambahkan!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Kategori gagal ditambahkan!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function hapusKategori()
    {
        if ($this->model('Kategori_model')->hapusKategori($_POST) > 0) {
            echo "<script>
                    alert('Kategori berhasil dihapus!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Kategori gagal dihapus!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function getKategoriById()
    {
        echo json_encode($this->model('Kategori_model')->getKategoriById($_POST['id']));
    }

    public function ubahKategori()
    {
        if ($this->model('Kategori_model')->ubahKategori($_POST) > 0) {
            echo "<script>
                    alert('Kategori berhasil diubah!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Kategori gagal diubah!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }
}
