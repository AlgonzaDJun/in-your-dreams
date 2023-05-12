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

  function changeContentReload(url) {
    // hide all content
    location.reload();

    // show the content for the selected tab
    changeContent(url);
    
  }

  function submitForm() {
    var formData = new FormData($("#form")[0]);
    var image = $('input[type=file]');

    // cek ukuran gambar
    if (image[0].files[0].size > 2000000) {
      $.toast({
        title: 'Error',
        subtitle: 'Baru Saja',
        content: 'Ukuran gambar terlalu besar, maksimal 2MB',
        type: 'error',
        delay: 4000
      });
      return 0;
    }

    // cek apakah ada field yang kosong
    var isEmptyField = [...formData.entries()].some(([name, value]) => {
      return typeof value === "string" && !value.trim();
    });
    if (!image.val().trim() || isEmptyField) {
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
    formData.append('gambar', image);
    var url = "<?= $view_public ?>" + "/produk/tambahProduk";
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
          content: 'Berhasil Menambah Produk :)',
          type: 'success',
          delay: 4000
        });
        return changeContent("produk");
      },
      error: function(data) {
        $.toast({
          title: 'Error',
          subtitle: 'Baru Saja',
          content: 'Gagal Menambah Produk :(',
          type: 'error',
          delay: 4000
        });
        return changeContent("produk");
      }
    });

  }

  function hapusProduk(id) {
    boot4.confirm({
      msg: "Yakin ingin hapus?",
      title: "Konfirmasi",
      callback: function(result) {
        if (result) {
          var url = "<?= $view_public ?>" + "/produk/hapusProduk";
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
                content: 'Berhasil Menghapus Produk :)',
                type: 'success',
                delay: 4000
              });
              return changeContent("produk");
            },
            error: function(data) {
              $.toast({
                title: 'Error',
                subtitle: 'Baru Saja',
                content: 'Gagal Menghapus Produk :(',
                type: 'error',
                delay: 4000
              });
              return changeContent("produk");
            }
          });
        } else {
          return 0;
        }
      }
    });
  }

  function ubahProduk() {
    var formData = new FormData($("#form")[0]);
    var image = $('input[type=file]');

    // cek ukuran gambar
    if (image[0].files[0].size > 2000000) {
      $.toast({
        title: 'Error',
        subtitle: 'Baru Saja',
        content: 'Ukuran gambar terlalu besar, maksimal 2MB',
        type: 'error',
        delay: 4000
      });
      return 0;
    }

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
    formData.append('gambar', image);
    var url = "<?= $view_public ?>" + "/produk/ubahProduk";
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
          content: 'Berhasil Mengubah Produk :)',
          type: 'success',
          delay: 4000
        });
        return changeContent("produk");
      },
      error: function(data) {
        $.toast({
          title: 'Error',
          subtitle: 'Baru Saja',
          content: 'Gagal Mengubah Produk :(',
          type: 'error',
          delay: 4000
        });
        return changeContent("produk");
      }
    });

  }

  $('.tampilModalTambah').click(function() {
    $('#exampleModalLabel').html('Tambah Produk');
    $('#nama_produk').val('');
    $('#merk').val('');
    $('#kategori').val('');
    $('#deskripsi').val('');
    $('#harga').val('');
    $('#stok').val('');
    $('#preview-gambar').html('');

    $('#submit-button').attr('onclick', 'return submitForm()');
  })


  $('.tampilModalUbah').click(function() {
    $('#exampleModalLabel').html('Ubah Produk');
    $('#submit-button').attr('onclick', 'return ubahProduk()');


    const id = $(this).data('id');

    $.ajax({
      url: '<?= $view_public ?>' + '/produk/getProdukById',
      data: {
        id: id
      },
      method: 'post',
      dataType: 'json',
      success: function(data) {
        $('#id').val(data.product_id);
        $('#nama_produk').val(data.product_name);
        $('#merk').val(data.merk_id);
        $('#kategori').val(data.category_id);
        $('#deskripsi').val(data.product_desc);
        $('#harga').val(data.price);
        $('#status').val(data.status);
        $('#stok').val(data.stock);
        $('#preview-gambar').html('<img src="http://localhost/toko_vica/public/img/products/' + data.image + '" width="150" height="auto"/>');
      }
    })
  })

  function imagePreview(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
      var fileReader = new FileReader();
      fileReader.onload = function(event) {
        $('#preview-gambar').html('<img src="' + event.target.result + '" width="150" height="auto"/>');
      };
      fileReader.readAsDataURL(fileInput.files[0]);
    }
  }

  $("#gambar").change(function() {
    imagePreview(this);
  });


  // test //
  function testToast() {
    $.toast({
      title: 'Success',
      subtitle: 'Baru Saja',
      content: 'Berhasil Menambah Produk <span style="font-size: 20px">&#128516;</span>',
      type: 'success',
      delay: 2500
    });
  }
</script>