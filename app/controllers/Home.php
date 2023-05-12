<?php

class Home extends Controller
{
    public function index()
    {
        $data['title'] = 'home';
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }

    public function chat()
    {
        $data['title'] = 'chat';
        if (isset($_SESSION['id']) == false) {
            echo '<script>alert("Anda harus login terlebih dahulu");</script>';
            echo "<script>location.href = '" . URL . "/login';</script>";
            exit;
        }
        $user['user_id'] = $_SESSION['id'];
        $data['chat'] = $this->model('Chat_model')->getChatBySenderId($user);
        $data['user'] = $this->model('User_model')->getUserById($user);
        $this->view('home/chat', $data);
    }   
}
