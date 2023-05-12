<?php

class User extends Controller
{
    public function index()
    {
        $data['title'] = 'user';
        $this->view('admin/chat', $data);
    }

    public function tambahUser()
    {
        if ($this->model('User_model')->tambahUser($_POST) > 0) {
            echo "<script>
                    alert('User berhasil ditambahkan!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('User gagal ditambahkan!');
                </script>";
            exit;
        }
    }

    // hapusUser()
    public function hapusUser()
    {
        if ($this->model('User_model')->hapusUser($_POST['id']) > 0) {
            echo "<script>
                    alert('User berhasil dihapus!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('User gagal dihapus!');
                </script>";
            exit;
        }
    }

    // getUserById()
    public function getUserByIdAdmin()
    {
        echo json_encode($this->model('User_model')->getUserByIdAdmin($_POST['id']));
    }

    // ubahUser()
    public function ubahUser()
    {
        if ($this->model('User_model')->ubahUser($_POST) > 0) {
            echo "<script>
                    alert('User berhasil diubah!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('User gagal diubah!');
                </script>";
            exit;
        }
    }
}
