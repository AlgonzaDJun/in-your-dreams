<?php

class Produk_model
{
    private $tabel = 'products';
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAllProducts()
    {
        $this->conn->query('select * from ' . $this->tabel);
        $allProd = $this->conn->resultSet();
        return $allProd;
    }

    // getAllMerk
    public function getAllMerk()
    {
        $this->conn->query('select * from merk');
        $allMerk = $this->conn->resultSet();
        return $allMerk;
    }

    // getAllKategori
    public function getAllKategori()
    {
        $this->conn->query('select * from categories');
        $allKategori = $this->conn->resultSet();
        return $allKategori;
    }

    // function upload gambar
    public function uploadGambar()
    {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        // cek apakah tidak ada gambar yang diupload
        if ($error === 4) {
            echo "<script>
                    alert('Pilih gambar terlebih dahulu!');
                </script>";
            return false;
        }

        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>
                    alert('Yang anda upload bukan gambar!');
                </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            echo "<script>
                    alert('Ukuran gambar terlalu besar!');
                </script>";
            return false;
        }

        // lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, './img/products/' . $namaFileBaru);
        return $namaFileBaru;
    }

    public function tambahProduk($data)
    {
        $query = "INSERT INTO products
                    VALUES
                    ('', :kategori_produk, :merk_produk, :nama_produk, :deskripsi_produk, :gambar_produk, :status_produk, :harga_produk, :stok_produk, :created_at, '')";
        $this->conn->query($query);
        $this->conn->bind('kategori_produk', $data['kategori']);
        $this->conn->bind('merk_produk', $data['merk']);
        $this->conn->bind('nama_produk', $data['nama']);
        $this->conn->bind('deskripsi_produk', $data['deskripsi']);
        $this->conn->bind('gambar_produk', $this->uploadGambar());
        $this->conn->bind('status_produk', $data['status']);
        $this->conn->bind('harga_produk', $data['harga']);
        $this->conn->bind('stok_produk', $data['stok']);
        $this->conn->bind('created_at', date('Y-m-d H:i:s'));
        $this->conn->execute();

        // if upload gambar fail
        if (!$this->uploadGambar()) {
            echo "<script>
                    alert('Gagal menambahkan produk!');
                </script>";
        }
        return $this->conn->rowCount();
    }

    public function ubahProduk($data)
    {
        // cek apakah user pilih gambar baru atau tidak
        if ($_FILES['gambar']['error'] === 4) {
            // $gambarLama = $_POST['gambarLama'];
            $query = "UPDATE products SET
                        category_id = :kategori_produk,
                        merk_id = :merk_produk,
                        product_name = :nama_produk,
                        product_desc = :deskripsi_produk,
                        status = :status_produk,
                        price = :harga_produk,
                        stock = :stok_produk,
                        updated_at = :updated_at
                    WHERE product_id = :id";
        } else {
            $query = "UPDATE products SET
                        category_id = :kategori_produk,
                        merk_id = :merk_produk,
                        product_name = :nama_produk,
                        product_desc = :deskripsi_produk,
                        image = :gambar_produk,
                        status = :status_produk,
                        price = :harga_produk,
                        stock = :stok_produk,
                        updated_at = :updated_at
                    WHERE product_id = :id";
        }

        $this->conn->query($query);
        $this->conn->bind('id', $data['id']);
        $this->conn->bind('kategori_produk', $data['kategori']);
        $this->conn->bind('merk_produk', $data['merk']);
        $this->conn->bind('nama_produk', $data['nama']);
        $this->conn->bind('deskripsi_produk', $data['deskripsi']);
        if ($_FILES['gambar']['error'] === 4) {
            // nothing here
        } else {
            $this->conn->bind('gambar_produk', $this->uploadGambar());
        }
        $this->conn->bind('status_produk', $data['status']);
        $this->conn->bind('harga_produk', $data['harga']);
        $this->conn->bind('stok_produk', $data['stok']);
        $this->conn->bind('updated_at', date('Y-m-d H:i:s'));
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function hapusProduk($data)
    {
        $query = "DELETE FROM products WHERE product_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $data['id']);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function getProdukById($id)
    {
        $query = "SELECT * FROM products WHERE product_id = :id";
        $this->conn->query($query);
        $this->conn->bind('id', $id);
        return $this->conn->single();
    }
}
