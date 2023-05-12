<?php

class Login extends Controller
{
    public function index()
    {
        $data['title'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = $this->model('User_model')->login($username, $password);
        if ($result == false) {
            $data['title'] = 'Login';
            $data['error'] = 'Username atau password salah';
            $this->view('auth/login', $data);
        }
    }

    public function logout()
    {
        $this->view('auth/logout');

        die();

        $_SESSION = [];
        session_unset();
        session_destroy();

        setcookie('id', '', time() - (3600 * 12));

        echo "<script>location.href = '" . URL . "/login';</script>";
        exit;
    }
}
