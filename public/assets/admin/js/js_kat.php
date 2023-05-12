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

        var url = "<?= $view_public ?>" + "/kategori/tambahKategori";
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
                return changeContent("kategori");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Menambah kategori :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("kategori");
            }
        });
    }

    function hapusKategori(id) {
        boot4.confirm({
            msg: "Yakin ingin hapus?",
            title: "Konfirmasi",
            callback: function(result) {
                if (result) {
                    var url = "<?= $view_public ?>" + "/kategori/hapusKategori";
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
                                content: 'Berhasil Menghapus Kategori :)',
                                type: 'success',
                                delay: 4000
                            });
                            return changeContent("kategori");
                        },
                        error: function(data) {
                            $.toast({
                                title: 'Error',
                                subtitle: 'Baru Saja',
                                content: 'Gagal Menghapus Kategori :(',
                                type: 'error',
                                delay: 4000
                            });
                            return changeContent("kategori");
                        }
                    });
                } else {
                    return 0;
                }
            }
        });
    }

    function ubahKategori() {
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
        var url = "<?= $view_public ?>" + "/kategori/ubahKategori";
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
                    content: 'Berhasil Mengubah kategori :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("kategori");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Mengubah kategori :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("kategori");
            }
        });

    }

    $('.tampilModalTambah').click(function() {
        $('#exampleModalLabel').html('Tambah Kategori');
        $('#nama_kategori').val('');
        $('#deskripsi').val('');
        $('#submit-button').attr('onclick', 'return submitForm()');
    })

    $('.tampilModalUbah').click(function() {
        $('#exampleModalLabel').html('Ubah Kategori');
        $('#submit-button').attr('onclick', 'return ubahKategori()');


        const id = $(this).data('id');

        $.ajax({
            url: '<?= $view_public ?>' + '/kategori/getKategoriById',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.category_id);
                $('#nama_kategori').val(data.category_name);
                $('#deskripsi').val(data.category_desc);
            }
        })
    })
</script>