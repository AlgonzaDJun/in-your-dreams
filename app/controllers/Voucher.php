<?php

class Voucher extends Controller {
    public function index()
    {
        $data['voucher'] = $this->model('Voucher_model')->getAllVoucher();
        $this->view('admin/voucher', $data);
    }

    public function tambahVoucher()
    {
        if ($this->model('Voucher_model')->tambahVoucher($_POST) > 0) {
            echo "<script>
                    alert('Voucher berhasil ditambahkan!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Voucher gagal ditambahkan!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function hapusVoucher()
    {
        if ($this->model('Voucher_model')->hapusVoucher($_POST) > 0) {
            echo "<script>
                    alert('Voucher berhasil dihapus!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Voucher gagal dihapus!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function getVoucherById()
    {
        echo json_encode($this->model('Voucher_model')->getVoucherById($_POST['id']));
    }

    public function ubahVoucher()
    {
        if ($this->model('Voucher_model')->ubahVoucher($_POST) > 0) {
            echo "<script>
                    alert('Voucher berhasil diubah!');
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Voucher gagal diubah!');
                </script>";
            exit;
        }
        // var_dump($_POST);
        // die;
    }

    public function getVoucherByKode()
    {
        echo json_encode($this->model('Voucher_model')->getVoucherByKode($_POST['kode']));
    }

}