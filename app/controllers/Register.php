<?php

class Register extends Controller
{
    // index()
    public function index()
    {
        $data['title'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('auth/register');
        $this->view('templates/footer');
    }

    // signup()
    public function signup()
    {

        function validatePhoneNumber($phoneNumber)
        {
            // Hapus karakter selain angka
            $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

            // Cek panjang nomor telepon
            if (strlen($phoneNumber) < 9) {
                return false;
            }

            // Cek awalan nomor telepon (hanya menerima awalan 08 atau +628)
            if (!preg_match('/^(08|\+628)/', $phoneNumber)) {
                return false;
            }

            // Nomor telepon valid
            return true;
        }

        $result = $this->model('User_model')->getUserByUsername($_POST);
        function checkUserExist($data)
        {
            if ($data > 0) {
                return true;
            } else {
                return false;
            }
        }




        if (validatePhoneNumber($_POST['nmr_telp']) && checkUserExist($result) == false) {
            if ($this->model('User_model')->tambahUser($_POST) > 0) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $this->model('User_model')->login($username, $password);
                exit;
            }
        } else {
            echo "<script>alert('Gagal Registrasi!');</script>";
            if (checkUserExist($result) == true) {
                echo "<script>alert('Username sudah terdaftar');</script>";
            }
            if (validatePhoneNumber($_POST['nmr_telp']) == false) {
                echo "<script>alert('Nomor telepon tidak valid');</script>";
            }
            echo "<script>location.href = '" . URL . "/register';</script>";
            exit;
        }
    }
}
