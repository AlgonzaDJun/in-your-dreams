<?php

class Kategori_model
{
    private $tabel = 'categories';
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAllKategori()
    {
        $this->conn->query('select * from ' . $this->tabel);
        $allKat = $this->conn->resultSet();
        return $allKat;
    }

    public function tambahKategori()
    {
        $query = "insert into " . $this->tabel . " values ('', :category_name, :category_desc)";
        $this->conn->query($query);
        $this->conn->bind('category_name', $_POST['nama']);
        $this->conn->bind('category_desc', $_POST['deskripsi']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function hapusKategori()
    {
        $query = "delete from " . $this->tabel . " where category_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function getKategoriById($id)
    {
        $query = "SELECT * FROM " . $this->tabel . " WHERE category_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $id);
        return $this->conn->single();
    }

    public function ubahKategori()
    {
        $query = "UPDATE " . $this->tabel . " SET
                    category_name = :nama_kategori,
                    category_desc = :deskripsi_kategori
                WHERE category_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->bind('nama_kategori', $_POST['nama']);
        $this->conn->bind('deskripsi_kategori', $_POST['deskripsi']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }
}
