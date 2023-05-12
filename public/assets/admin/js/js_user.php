<?php
$view_admin = "http://localhost/toko_vica/app/views/admin/";
$view_public = "http://localhost/toko_vica";
?>

<script>
    function changeContent(url) {
        // hide all content
        $(".container-fluid").html("");

        // show the content for the selected tab
        $.ajax({
            url: '<?= $view_public ?>' + '/admin/' + url,
            type: "GET",
            success: function(data) {
                $(".container-fluid").html(data);
            }
        });
    }

    function submitForm() {
        var formData = new FormData($("#form")[0]);
        var isEmptyField = [...formData.entries()].some(([name, value]) => {
            return typeof value === "string" && !value.trim();
        });
        // validasi password
        var password = $('#password').val();
        if (password.length < 5) {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Password minimal 5 karakter',
                type: 'error',
                delay: 4000
            });
            return 0;
        }
        if (password.indexOf(' ') >= 0) {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Password tidak boleh ada spasi',
                type: 'error',
                delay: 4000
            });
            return 0;
        }
        if (isEmptyField) {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Ada isian yang kosong, silakan isi semua field',
                type: 'error',
                delay: 4000
            });
            return 0;
        }
        var url = "<?= $view_public ?>" + "/user/tambahUser";
        $.ajax({
            type: "POST",
            url: url,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                // load the page
                $.toast({
                    title: 'Success',
                    subtitle: 'Baru Saja',
                    content: 'Berhasil Menambah user :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("user");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Menambah user :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("user");
            }
        });
    }

    function hapusUser(id) {
        boot4.confirm({
            msg: "Yakin ingin hapus?",
            title: "Konfirmasi",
            callback: function(result) {
                if (result) {
                    var url = "<?= $view_public ?>" + "/user/hapusUser";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            id: id
                        },
                        success: function(data) {
                            // load the page
                            $.toast({
                                title: 'Success',
                                subtitle: 'Baru Saja',
                                content: 'Berhasil Menghapus user :)',
                                type: 'success',
                                delay: 4000
                            });
                            return changeContent("user");
                        },
                        error: function(data) {
                            $.toast({
                                title: 'Error',
                                subtitle: 'Baru Saja',
                                content: 'Gagal Menghapus user :(',
                                type: 'error',
                                delay: 4000
                            });
                            return changeContent("user");
                        }
                    });
                } else {
                    return 0;
                }
            }
        });
    }

    function ubahUser() {
        var formData = new FormData($("#form")[0]);

        // cek apakah ada field yang kosong
        var isEmptyField = [...formData.entries()].some(([name, value]) => {
            return typeof value === "string" && !value.trim();
        });

        // validasi field password, tidak ada spasi, minimal 6 karakter
        var password = $('#password').val();
        if (password.length < 5) {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Password minimal 5 karakter',
                type: 'error',
                delay: 4000
            });
            return 0;
        }
        if (password.indexOf(' ') >= 0) {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Password tidak boleh ada spasi',
                type: 'error',
                delay: 4000
            });
            return 0;
        }

        if (isEmptyField) {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Ada isian yang kosong, silakan isi semua field',
                type: 'error',
                delay: 4000
            });
            return 0;
        }

        // jika tidak ada field yang kosong
        var url = "<?= $view_public ?>" + "/user/ubahUser";
        $.ajax({
            type: "POST",
            url: url,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                // load the page
                $.toast({
                    title: 'Success',
                    subtitle: 'Baru Saja',
                    content: 'Berhasil Mengubah user :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("user");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Mengubah user :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("user");
            }
        });

    }

    $('.tampilModalTambah').click(function() {
        $('#exampleModalLabel').html('Tambah User');
        $('#nama_lengkap').val('');
        $('#username').val('');
        $('#password').val('');
        $('#nmr_telp').val('');
        $('#alamat').val('');
        $('#email').val('');
        $('#submit-button').attr('onclick', 'return submitForm()');
    })

    $('.tampilModalUbah').click(function() {
        $('#exampleModalLabel').html('Ubah User');
        $('#submit-button').attr('onclick', 'return ubahUser()');


        const id = $(this).data('id');

        $.ajax({
            url: '<?= $view_public ?>' + '/user/getUserByIdAdmin',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                // nama_lengkap
                $('#nama_lengkap').val(data.nama_lengkap);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#nmr_telp').val(data.nmr_telp);
                $('#alamat').val(data.alamat);
                $('#email').val(data.email);
                $('#id').val(data.user_id);
            }
        })
    })
</script>