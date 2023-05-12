<?php

require __DIR__ . '/../../public/assets/admin/vendor/autoload.php';

class Chat_model
{
    private $tabel = 'messages';
    private $conn;
    // make this private 
    private $app_id = "1576805";
    private $key = "c9ce2e95cbf7337b0b48";
    private $secret = "2341eaca8dd35a982e4b";
    private $beamsSecretKey = "BE793CEB7D82DAA8A91FB3DB45D3D18BF33196C48EF7949783CB6B1B4387397C";
    private $cluster = "ap1";
    private $instanceId = "56d09156-cdfb-4f41-9d32-fe3c822329ac";
    private $channel = "my-channel";
    private $limit = 100;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getChatBySenderId($data)
    {
        $this->changeStatusMessage($data['user_id']);
        $countRow = "SELECT COUNT(*) FROM messages where sender_id = $data[user_id] OR receiver_id = $data[user_id]";
        $this->conn->query($countRow);
        $count = $this->conn->single();
        // convert to int $count = $count['COUNT(*)'];
        $count = (int) $count['COUNT(*)'];

        if (!isset($_POST['chatKelipatan'])) {
            $kelipatan = 1;
        } else {
            $kelipatan = $_POST['chatKelipatan'];
        }

        // if $count < 10
        if ($count < 10) {
            $count = 0;
        } else {
            $count = $count - (10 * $kelipatan);
        }


        $this->conn->query("SELECT * FROM $this->tabel WHERE sender_id = :sender_id OR receiver_id = :receiver_id LIMIT $count,10");
        $this->conn->bind('sender_id', $data['user_id']);
        $this->conn->bind('receiver_id', $data['user_id']);

        // var_dump($this->conn->resultSet());
        return $this->conn->resultSet();
    }

    public function uploadGambar()
    {
        $namaFile = $_FILES['gambar']['name'];
        // $ukuranFile = $_FILES['gambar']['size'];
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
        // if ($ukuranFile > 2000000) {
        //     echo "<script>
        //             alert('Ukuran gambar terlalu besar!');
        //         </script>";
        //     return false;
        // }

        // lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, './public/img/chat/' . $namaFileBaru);
        return $namaFileBaru;
    }

    public function sendMessage()
    {
        // search user by id
        $user1 = $this->conn->query("SELECT * FROM user WHERE user_id = :id");
        $user2 = $this->conn->bind('id', $_POST['user_id']);
        $user = $this->conn->single();
        $nama_user = $user['nama_lengkap'];
        if (empty($_FILES['gambar'])) {
            $image = NULL;
        } else {
            $image = $this->uploadGambar();
        }
        // insert to messages 	id_message	sender_id	message	image_path	created_at
        if ($_POST['action'] == 'sendMessage') {
            $data['message'] = $_POST['message'];
            $data['user_id'] = $_POST['user_id'];
            $data['nama_user'] = $nama_user;
            $data['receiver_id'] = $_POST['receiver_id'];
            $data['gambar'] = $image;
            $pusher = new Pusher\Pusher($this->key, $this->secret, $this->app_id, array('cluster' => $this->cluster));
            $pusher->trigger($_POST['channel'], 'send', $data);
            if ($_POST['user_id'] != $_POST['receiver_id']) {
                $this->sendNotification($_POST['receiver_interest'], $_POST['message'], $nama_user);
            }
        }

        // if $_post image_path is empty
        // if (empty($_FILES['gambar'])) {
        //     $image = null;
        // } else {
        //     $image = $this->uploadGambar();
        // }

        if ($image == false) {
            echo "<script>
                    alert('Upload gambar gagal!');
                </script>";
        }

        $query = "INSERT INTO $this->tabel VALUES ('', :sender_id, :receiver_id, :message, :image_path, DEFAULT, DEFAULT)";
        $this->conn->query($query);
        $this->conn->bind('sender_id', $_POST['user_id']);
        $this->conn->bind('receiver_id', $_POST['receiver_id']);
        $this->conn->bind('message', $_POST['message']);
        $this->conn->bind('image_path', $image);
        $this->conn->execute();
        return $this->conn->rowCount();
    }

    public function getData()
    {
        var_dump($_POST['gambar']);
    }

    // sendNotification
    public function sendNotification($receiver, $message, $sender)
    {
        $pushNotifications = new \Pusher\PushNotifications\PushNotifications(array(
            "instanceId" => $this->instanceId,
            "secretKey" => $this->beamsSecretKey,
        ));

        if ($receiver != 'admin') {
            $url = URL . "/home/chat";
        } else {
            $url = URL . "/admin";
        }
        $publishResponse = $pushNotifications->publishToInterests(
            ["$receiver"],
            [
                "web" => [
                    "notification" => [
                        "title" => "$sender",
                        "body" => "$message",
                        "deep_link" => $url,
                        "icon" => "https://cdn-icons-png.flaticon.com/512/2415/2415292.png",
                        "actions" => [
                            [
                                "title" => "Open",
                                "url" => $url,
                            ],
                            [
                                "title" => "Close",
                            ],
                        ],
                    ],
                ],
            ]
        );
        echo "Published with Publish ID: {$publishResponse->publishId}";
    }

    public function getUnreadMessage()
    {
        // $query = "SELECT m1.*, u.nama_lengkap AS sender_name, m2.total_unread AS total_unread FROM messages m1 INNER JOIN( SELECT sender_id, MAX(created_at) AS max_created_at, COUNT(*) AS total_unread FROM messages WHERE read_status = 0 AND sender_id != 1 GROUP BY sender_id ) m2 ON m1.sender_id = m2.sender_id AND m1.created_at = m2.max_created_at INNER JOIN USER u ON m1.sender_id = u.user_id ORDER BY m2.max_created_at DESC";
        $query = "SELECT u.nama_lengkap AS sender_name, u.user_id, IFNULL(m1.id_message, '0') AS id_message, IFNULL(m1.sender_id, '0') AS sender_id, IFNULL(m1.receiver_id, '0') AS receiver_id, IFNULL(m1.message, 'Belum ada pesan') AS message, IFNULL(m1.image_path, '') AS image_path, IFNULL(m1.read_status, '0') AS read_status, IFNULL(m1.created_at, '') AS created_at, IFNULL(m2.total_unread, '') AS total_unread FROM user u LEFT JOIN ( SELECT sender_id, MAX(created_at) AS max_created_at, COUNT(*) AS total_unread FROM messages WHERE read_status = 0 AND sender_id != 1 GROUP BY sender_id ) m2 ON u.user_id = m2.sender_id LEFT JOIN messages m1 ON m2.sender_id = m1.sender_id AND m2.max_created_at = m1.created_at WHERE u.user_id != 1 ORDER BY m2.max_created_at DESC";
        $this->conn->query($query);
        return $this->conn->resultSet();
    }

    public function changeStatusMessage($id)
    {
        // cek jika ada pesan yang belum dibaca
        $query = "SELECT * FROM $this->tabel WHERE sender_id = :sender_id AND read_status = 0";
        $this->conn->query($query);
        $this->conn->bind('sender_id', $id);
        $belum = $this->conn->resultSet();

        if (empty($belum)) {
            return 0;
        } else {
            // update status pesan
            $query = "UPDATE $this->tabel SET read_status = 1 WHERE sender_id = :sender_id";
            $this->conn->query($query);
            $this->conn->bind('sender_id', $id);
            $this->conn->execute();
            return $this->conn->rowCount();
        }
    }
}
