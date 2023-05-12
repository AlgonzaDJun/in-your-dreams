<?php

class Merk_model
{
    private $tabel = 'merk';
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAllMerk()
    {
        $this->conn->query('select * from ' . $this->tabel);
        $allMerk = $this->conn->resultSet();
        return $allMerk;
    }

    public function tambahMerk()
    {
        $query = "insert into " . $this->tabel . " values ('', :merk_name, :merk_desc)";
        $this->conn->query($query);
        $this->conn->bind('merk_name', $_POST['nama']);
        $this->conn->bind('merk_desc', $_POST['deskripsi']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function hapusMerk()
    {
        $query = "delete from " . $this->tabel . " where merk_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function getMerkById()
    {
        $query = "select * from " . $this->tabel . " where merk_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        return $this->conn->single();
    }

    public function ubahMerk()
    {
        $query = "update " . $this->tabel . " set
                    merk_name = :nama_merk,
                    merk_desc = :deskripsi_merk
                where merk_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->bind('nama_merk', $_POST['nama']);
        $this->conn->bind('deskripsi_merk', $_POST['deskripsi']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

}
