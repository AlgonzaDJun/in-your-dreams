<?php

class Voucher_model
{
    private $table = 'voucher';
    private $conn;

    public function __construct()
    {
        $this->conn = new Database;
    }

    public function getAllVoucher()
    {
        $this->conn->query('select * from ' . $this->table);
        $allVoucher = $this->conn->resultSet();
        return $allVoucher;
    }

    public function tambahVoucher()
    {
        // kolom id, code, discount, startdate, enddate
        $query = "insert into " . $this->table . " values ('', :code, :discount, :startdate, :enddate)";
        $startdate = date('Y-m-d H:i:s', strtotime($_POST['startdate']));
        $enddate = date('Y-m-d 23:59:59', strtotime($_POST['enddate'] . ' + 1 day - 1 second'));
        $this->conn->query($query);
        $this->conn->bind('code', $_POST['code']);
        $this->conn->bind('discount', $_POST['discount']);
        $this->conn->bind('startdate', $startdate);
        $this->conn->bind('enddate', $enddate);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function hapusVoucher()
    {
        $query = "delete from " . $this->table . " where voucher_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function getVoucherById()
    {
        $query = "select * from " . $this->table . " where voucher_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        return $this->conn->single();
    }

    public function ubahVoucher()
    {
        $query = "update " . $this->table . " set
                    code = :code,
                    discount = :discount,
                    startdate = :startdate,
                    enddate = :enddate
                where voucher_id = :id";
        $startdate = date('Y-m-d H:i:s', strtotime($_POST['startdate']));
        $enddate = date('Y-m-d 23:59:59', strtotime($_POST['enddate'] . ' + 1 day - 1 second'));
        $this->conn->query($query);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->bind('code', $_POST['code']);
        $this->conn->bind('discount', $_POST['discount']);
        $this->conn->bind('startdate', $startdate);
        $this->conn->bind('enddate', $enddate);
        $this->conn->execute();
        return $this->conn->rowCount();
    }
}
