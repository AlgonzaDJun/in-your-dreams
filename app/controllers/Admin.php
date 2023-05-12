<?php

class Admin extends Controller
{
    public function index()
    {
        $data['unread_chat'] = $this->model('Chat_model')->getUnreadMessage();
        $data['produk'] = $this->model('Produk_model')->getAllProducts();
        $this->view('admin/index', $data);
    }

    public function produk()
    {
        $data['produk'] = $this->model('Produk_model')->getAllProducts();
        $data['merk'] = $this->model('Produk_model')->getAllMerk();
        $data['kategori'] = $this->model('Produk_model')->getAllKategori();
        $this->view('admin/produk', $data);
    }

    // make function kategori, merk, voucher
    public function kategori()
    {
        $data['kategori'] = $this->model('Kategori_model')->getAllKategori();
        $this->view('admin/kategori', $data);
    }

    public function merk()
    {
        $data['merk'] = $this->model('Merk_model')->getAllMerk();
        $this->view('admin/merk', $data);
    }

    public function voucher()
    {
        $data['voucher'] = $this->model('Voucher_model')->getAllVoucher();
        $this->view('admin/voucher', $data);
    }

    public function order()
    {
        $data['order'] = $this->model('Order_model')->getAllOrder();
        $this->view('admin/order/index', $data);
    }

    public function addOrder()
    {
        $data['user'] = $this->model('User_model')->getAllUser();
        $data['produk'] = $this->model('Produk_model')->getAllProducts();
        $data['voucher'] = $this->model('Voucher_model')->getAllVoucher();
        $this->view('admin/order/add', $data);
    }

    public function chat()
    {
        $data['unread_chat'] = $this->model('Chat_model')->getUnreadMessage();
        $data['user'] = $this->model('User_model')->getAllUser();
        $this->view('admin/chat/index', $data);
    }

    public function user()
    {
        $data['user'] = $this->model('User_model')->getAllUser();
        $this->view('admin/user', $data);
    }

    public function kirim()
    {
        $this->view('admin/chat/kirim');
    }

}
