<?php

class Chat extends Controller
{
    public function index()
    {
        $data['title'] = 'Chat';
        $this->view('templates/header', $data);
        $this->view('chat/index', $data);
        $this->view('templates/footer');
    }

    public function sendMessage()
    { 
        $this->model('Chat_model')->sendMessage();
    }

    public function getChatBySenderId()
    {
        $data['user'] = $this->model('User_model')->getUserById($_POST);
        $data['chat'] = $this->model('Chat_model')->getChatBySenderId($_POST);
        $this->view('admin/chat/getChatBySender', $data);
    }

    public function getChatUser()
    {
        $data['user'] = $this->model('User_model')->getUserById($_POST);
        $data['chat'] = $this->model('Chat_model')->getChatBySenderId($_POST);
        $this->view('home/getChat', $data);
    }

    public function kirim()
    {
        $this->view('admin/chat/kirim');
    }

    public function sendNotification()
    {
        $this->model('Chat_model')->sendNotification();
    }

    public function getUnreadMessage()
    {
        $data['unread_chat'] = $this->model('Chat_model')->getUnreadMessage();
    }

    public function changeStatus()
    {
        $this->model('Chat_model')->changeStatusMessage();
    }
}
