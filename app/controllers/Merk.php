<?php

class Merk extends Controller
{
    public function index()
    {
        $data['merk'] = $this->model('Merk_model')->getAllMerk();
        $this->view('admin/merk', $data);
    }

    public function tambahMerk()
    {
        if ($this->model('Merk_model')->tambahMerk($_POST) > 0) {
            echo "<script>
                    alert('Merk berhasil ditambahkan!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Merk gagal ditambahkan!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function hapusMerk()
    {
        if ($this->model('Merk_model')->hapusMerk($_POST) > 0) {
            echo "<script>
                    alert('Merk berhasil dihapus!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Merk gagal dihapus!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function getMerkById()
    {
        echo json_encode($this->model('Merk_model')->getMerkById($_POST['id']));
    }

    public function ubahMerk()
    {
        if ($this->model('Merk_model')->ubahMerk($_POST) > 0) {
            echo "<script>
                    alert('Merk berhasil diubah!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Merk gagal diubah!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }
}
