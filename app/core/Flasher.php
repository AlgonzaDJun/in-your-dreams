<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi' => $aksi,
            'tipe' => $tipe
        ];
    }

    public static function flash()
    {
        if(isset($_SESSION['flash'])) {
            $tipe = $_SESSION['flash']['tipe'];
            $pesan = $_SESSION['flash']['pesan'];
            $aksi = $_SESSION['flash']['aksi'];
            
            echo "<script>
                $.toast({
                    title: $tipe,
                    subtitle: '11 mins ago',
                    content: $pesan . ' ' .  $aksi,
                    type: $tipe,
                    delay: 2000
                })
                </script>";
            unset($_SESSION['flash']);
        }
    }
}