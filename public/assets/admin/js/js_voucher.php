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

        var url = "<?= $view_public ?>" + "/voucher/tambahVoucher";
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
                    content: 'Berhasil Menambah voucher :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("voucher");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Menambah voucher :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("voucher");
            }
        });
    }

    function hapusVoucher(id) {
        boot4.confirm({
            msg: "Yakin ingin hapus?",
            title: "Konfirmasi",
            callback: function(result) {
                if (result) {
                    var url = "<?= $view_public ?>" + "/voucher/hapusVoucher";
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
                                content: 'Berhasil Menghapus voucher :)',
                                type: 'success',
                                delay: 4000
                            });
                            return changeContent("voucher");
                        },
                        error: function(data) {
                            $.toast({
                                title: 'Error',
                                subtitle: 'Baru Saja',
                                content: 'Gagal Menghapus voucher :(',
                                type: 'error',
                                delay: 4000
                            });
                            return changeContent("voucher");
                        }
                    });
                } else {
                    return 0;
                }
            }
        });
    }

    function ubahVoucher() {
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
        var url = "<?= $view_public ?>" + "/voucher/ubahVoucher";
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
                    content: 'Berhasil Mengubah voucher :)',
                    type: 'success',
                    delay: 4000
                });
                return changeContent("voucher");
            },
            error: function(data) {
                $.toast({
                    title: 'Error',
                    subtitle: 'Baru Saja',
                    content: 'Gagal Mengubah voucher :(',
                    type: 'error',
                    delay: 4000
                });
                return changeContent("voucher");
            }
        });
    }

    $('.tampilModalTambah').click(function() {
        $('#exampleModalLabel').html('Tambah Voucher');
        $('#submit-button').attr('onclick', 'return submitForm()');
        $('#kode_voucher').val('');
        $('#discount').val('');
        $('#startdate').val('');
        $('#enddate').val('');

    })

    $('.tampilModalUbah').click(function() {
        $('#exampleModalLabel').html('Ubah Voucher');
        $('#submit-button').attr('onclick', 'return ubahVoucher()');


        const id = $(this).data('id');

        $.ajax({
            url: '<?= $view_public ?>' + '/voucher/getVoucherById',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                // element id : id, kode_voucher, discount, startdate, enddate
                var startdate = new Date(data.startdate);
                var enddate = new Date(data.enddate);
                var startdateStr = startdate.toISOString().substr(0, 10);
                var enddateStr = enddate.toISOString().substr(0, 10);
                $('#id').val(data.voucher_id);
                $('#kode_voucher').val(data.code);
                $('#discount').val(data.discount);
                $('#startdate').val(startdateStr);
                $('#enddate').val(enddateStr);

            }
        })
    })
</script>