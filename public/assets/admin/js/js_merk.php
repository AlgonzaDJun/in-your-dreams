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

        var url = "<?= $view_public ?>" + "/merk/tambahMerk";
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
                    content: 'Berhasil Menambah kategori :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("merk");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Menambah kategori :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("merk");
            }
        });
    }

    function hapusMerk(id) {
        boot4.confirm({
            msg: "Yakin ingin hapus?",
            title: "Konfirmasi",
            callback: function(result) {
                if (result) {
                    var url = "<?= $view_public ?>" + "/merk/hapusMerk";
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
                                content: 'Berhasil Menghapus merk :)',
                                type: 'success',
                                delay: 4000
                            });
                            return changeContent("merk");
                        },
                        error: function(data) {
                            $.toast({
                                title: 'Error',
                                subtitle: 'Baru Saja',
                                content: 'Gagal Menghapus merk :(',
                                type: 'error',
                                delay: 4000
                            });
                            return changeContent("merk");
                        }
                    });
                } else {
                    return 0;
                }
            }
        });
    }

    function ubahMerk() {
        var formData = new FormData($("#form")[0]);

        // cek apakah ada field yang kosong
        var isEmptyField = [...formData.entries()].some(([name, value]) => {
            return typeof value === "string" && !value.trim();
        });
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
        var url = "<?= $view_public ?>" + "/merk/ubahMerk";
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
                    content: 'Berhasil Mengubah merk :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("merk");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Mengubah merk :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("merk");
            }
        });
    }

    $('.tampilModalTambah').click(function() {
        $('#exampleModalLabel').html('Tambah merk');
        $('#nama_merk').val('');
        $('#deskripsi').val('');
        $('#submit-button').attr('onclick', 'return submitForm()');
    })

    $('.tampilModalUbah').click(function() {
        $('#exampleModalLabel').html('Ubah merk');
        $('#submit-button').attr('onclick', 'return ubahMerk()');


        const id = $(this).data('id');

        $.ajax({
            url: '<?= $view_public ?>' + '/merk/getMerkById',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.merk_id);
                $('#nama_merk').val(data.merk_name);
                $('#deskripsi').val(data.merk_desc);
            }
        })
    })
</script>