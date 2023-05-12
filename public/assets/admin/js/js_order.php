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

    $('#pemesan').on('change', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?= $view_public ?>' + '/order/getOrdersTemp/' + id,
            type: "GET",
            success: function(data) {
                $("#ubahTable").html(data);
            }
        });
    })

    function tambahProdukOrder() {
        var pemesan = $("#pemesan").val();
        var selectedProduct = $('#product').val();
        var price = $('#product option[value="' + selectedProduct + '"]').data('price');
        if (pemesan == "") {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Pemesan belum dipilih',
                type: 'error',
                delay: 4000
            });
            return 0;
        }

        if (selectedProduct == "") {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Produk belum dipilih',
                type: 'error',
                delay: 4000
            });
            return 0;
        }

        var formData = new FormData($("#form")[0]);
        formData.append('price', price);

        // for loop console log formData
        // for (var pair of formData.entries()) {
        //     console.log(pair[0] + ', ' + pair[1]);
        // }

        var url = "<?= $view_public ?>" + "/order/tambahOrderTemp";
        $.ajax({
            type: "POST",
            url: url,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                $("#ubahTable").load('<?= $view_public ?>' + '/order/getOrdersTemp/' + pemesan);
            }
        })
    }

    function hapusOrderTemp(id) {
        var pemesan = $("#pemesan").val();
        var url = "<?= $view_public ?>" + "/order/hapusOrderTemp";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: id
            },
            success: function(data) {
                $("#ubahTable").load('<?= $view_public ?>' + '/order/getOrdersTemp/' + pemesan);
            }
        })
    }

    function tambahOrder() {
        var method = $("#payment_method").val();
        var status = $("#status").val();
        var alamat = $("#alamat").val();

        if (method == "") {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Metode Pembayaran belum dipilih',
                type: 'error',
                delay: 4000
            });
            return 0;
        } else if (status == "") {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Status belum dipilih',
                type: 'error',
                delay: 4000
            });
            return 0;
        } else if (alamat == "") {
            $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Alamat belum diisi',
                type: 'error',
                delay: 4000
            });
            return 0;
        }

        var totalPrice = $("input[name='total_price']").val();
        var formData = new FormData($("#form")[0]);
        formData.append('total_price', totalPrice);

        var url = "<?= $view_public ?>" + "/order/tambahOrder";

        $.ajax({
            type: "POST",
            url: url,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                $.toast({
                    title: 'Success',
                    subtitle: 'Baru Saja',
                    content: 'Order berhasil ditambahkan',
                    type: 'success',
                    delay: 4000
                });
                return changeContent('order');
            }
        })
    }

    $('.tampilModalUbah').click(function() {
        var id = $(this).data('id');
        // ajax post
        var url = "<?= $view_public ?>" + "/order/getOrderById";
        $.ajax({
            url: url,
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                // pemesan harga_total kode_voucher after_diskon payment_method status alamat
                $('#order_id').val(data.order_id);
                $('#pemesan').val(data.nama_lengkap);
                $('#total_price').val(data.hrg_total);
                $('#kode_voucher').val(data.code);
                $('#after_diskon').val(data.after_discount);
                $('#payment_method').val(data.payment_method);
                $('#status').val(data.status);
                $('#alamat').val(data.alamat);

                $.ajax({
                    url: '<?= $view_public ?>' + '/order/getOrdersItems/' + id,
                    type: "GET",
                    success: function(data) {
                        $("#order_items").html(data);
                    }
                });
            }
        })

        $('#status').on('change', function() {
            var status = $(this).val();
            var id = $("input[name='order_id']").val();

            // ajax post status and id
            var url = "<?= $view_public ?>" + "/order/ubahStatus";
            $.ajax({
                url: url,
                data: {
                    id: id,
                    status: status
                },
                method: 'post',
                success: function(data) {
                    $.toast({
                        title: 'Success',
                        subtitle: 'Baru Saja',
                        content: 'Status berhasil diubah',
                        type: 'success',
                        delay: 4000
                    });
                }
            })

            // $('#exampleModal').on('hidden.bs.modal', function() {
            //     return changeContent('order');
            // });
        })

        $('#payment_method').on('change', function() {
            var method = $(this).val();
            var id = $("input[name='order_id']").val();

            // ajax post method and id
            var url = "<?= $view_public ?>" + "/order/ubahMetodePembayaran";
            $.ajax({
                url: url,
                data: {
                    id: id,
                    payment_method: method
                },
                method: 'post',
                success: function(data) {
                    $.toast({
                        title: 'Success',
                        subtitle: 'Baru Saja',
                        content: 'Pembayaran berhasil diubah',
                        type: 'success',
                        delay: 4000
                    });
                }
            })

            // $('#exampleModal').on('hidden.bs.modal', function() {
            //     return changeContent('order');
            // });
        })
    })

    function ubahAlamat() {
        var alamat = $("#alamat").val();
        var id = $("input[name='order_id']").val();

        // ajax post alamat and id
        var url = "<?= $view_public ?>" + "/order/ubahAlamat";
        $.ajax({
            url: url,
            data: {
                id: id,
                alamat: alamat
            },
            method: 'post',
            success: function(data) {
                $.toast({
                    title: 'Success',
                    subtitle: 'Baru Saja',
                    content: 'Alamat berhasil diubah',
                    type: 'success',
                    delay: 4000
                });
            }
        })

        // $('#exampleModal').on('hidden.bs.modal', function() {
        //     return changeContent('order');
        // });
    }

    function hapusOrderItems(id) {
        $('#exampleModal').on('shown.bs.modal', function() {
            $(this).focus();
        });

        var url = "<?= $view_public ?>" + "/order/hapusOrderItems";
        var id_order = $("input[name='order_id']").val();

        // confirm hapus
        boot4.confirm({
            msg: "Yakin ingin hapus?",
            title: "Konfirmasi",
            callback: function(result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            id: id
                        },
                        success: function(data) {
                            $.ajax({
                                url: '<?= $view_public ?>' + '/order/getOrdersItems/' + id_order,
                                type: "GET",
                                success: function(data) {
                                    $('#order_items').replaceWith(data);
                                }
                            });

                            $.toast({
                                title: 'Success',
                                subtitle: 'Baru Saja',
                                content: 'Order berhasil dihapus',
                                type: 'success',
                                delay: 4000
                            });
                        }
                    })
                } else {
                    $('#exampleModal').focus();
                    return 0;
                }
            }
        });

    }

    // function formatNumber(num, decPlaces, thouSeparator, decSeparator) {
    //     decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    //         decSeparator = decSeparator == undefined ? "." : decSeparator,
    //         thouSeparator = thouSeparator == undefined ? "," : thouSeparator;
    //     var sign = num < 0 ? "-" : "";
    //     var i = parseInt(num = Math.abs(+num || 0).toFixed(decPlaces)) + "";
    //     var j = (j = i.length) > 3 ? j % 3 : 0;
    //     return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(num - i).toFixed(decPlaces).slice(2) : "");
    // }
    // var angka = parseFloat($("#input-angka").val());

    // $('#input-angka2').on('keyup', function() {
    //     var angka = parseFloat($("#input-angka").val());

    //     // Memformat angka menggunakan fungsi formatNumber()
    //     var angkaFormatted = formatNumber(angka, $(this).val(), ",", ".");

    //     // Menampilkan hasil format pada elemen HTML dengan id "output-angka"
    //     $("#output-angka").text(angkaFormatted);
    // });


    // // Memformat angka menggunakan fungsi formatNumber()
    // $("#input-angka").on("keyup", function() {
    //     var angka = parseFloat($(this).val());

    //     // Memformat angka menggunakan fungsi formatNumber()
    //     var angkaFormatted = formatNumber(angka, $('#input-angka2').val(), ",", ".");

    //     // Menampilkan hasil format pada elemen HTML dengan id "output-angka"
    //     $("#output-angka").text(angkaFormatted);
    // });

    $('#exampleModal').on('hidden.bs.modal', function() {
        return changeContent('order');
    });
</script>