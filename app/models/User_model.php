<?php
// session_start();

class User_model
{
    private $tabel = 'user';
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAllUser()
    {
        $this->conn->query("select * from " . $this->tabel . " where role = 'user'");
        $allUser = $this->conn->resultSet();
        return $allUser;
    }

    public function getUserById($data)
    {
        $this->conn->query("select * from " . $this->tabel . " where user_id = :id");
        $this->conn->bind('id', $data['user_id']);
        $user = $this->conn->single();
        return $user;
    }

    // getuserby username
    public function getUserByUsername($data)
    {
        $this->conn->query("select * from " . $this->tabel . " where username = :username");
        $this->conn->bind('username', $data['username']);
        $user = $this->conn->single();
        return $user;
    }

    public function login($username, $password)
    {
        try {
            $this->conn->query("select * from " . $this->tabel . " where username = :username");
            $this->conn->bind('username', $username);
            $user = $this->conn->single();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                setcookie('id', $user['user_id'], time() + 3600 * 12, '/toko_vica', 'localhost', false, true);

                if ($user['role'] == 'admin') {
                    header("Location: ../admin/index");
                    exit();
                } else {
                    header("Location: ../home");
                    exit();
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function tambahUser()
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "insert into " . $this->tabel . " values ('', :nama_lengkap, :username, :password, :nmr_telp, :alamat, :email, 'user')";
        $this->conn->query($query);
        $this->conn->bind('nama_lengkap', $_POST['nama_lengkap']);
        $this->conn->bind('username', $_POST['username']);
        $this->conn->bind('password', $password);
        $this->conn->bind('nmr_telp', $_POST['nmr_telp']);
        $this->conn->bind('alamat', $_POST['alamat']);
        $this->conn->bind('email', $_POST['email']);
        $this->conn->execute();

        return $this->conn->rowCount();
    }

    // hapusUser()
    public function hapusUser($id)
    {
        $this->conn->query("delete from " . $this->tabel . " where user_id = :id");
        $this->conn->bind('id', $id);
        $this->conn->execute();

        return $this->conn->rowCount();
    }

    // getUserByIdAdmin()
    public function getUserByIdAdmin($id)
    {
        $this->conn->query("select * from " . $this->tabel . " where user_id = :id");
        $this->conn->bind('id', $id);
        $user = $this->conn->single();
        return $user;
    }

    // editUser()
    public function ubahUser($data)
    {
        $userLama = $this->getUserByIdAdmin($data['id']);

        // jika password tidak diubah, maka password tetap
        if ($_POST['password'] == $userLama['password']) {
            $password = $_POST['password'];
        } else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            echo "password diubah";
        }
        $query = "update " . $this->tabel . " set nama_lengkap = :nama_lengkap, username = :username, password = :password, nmr_telp = :nmr_telp, alamat = :alamat, email = :email where user_id = :id";
        $this->conn->query($query);
        $this->conn->bind('nama_lengkap', $_POST['nama_lengkap']);
        $this->conn->bind('username', $_POST['username']);
        $this->conn->bind('password', $password);
        $this->conn->bind('nmr_telp', $_POST['nmr_telp']);
        $this->conn->bind('alamat', $_POST['alamat']);
        $this->conn->bind('email', $_POST['email']);
        $this->conn->bind('id', $_POST['id']);
        $this->conn->execute();

        return $this->conn->rowCount();
    }
}
