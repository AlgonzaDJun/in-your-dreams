<?php
$view_public = "http://localhost/toko_vica";
?>

<script>
    $(document).ready(function() {

        scrollToBottom();

        var imageBox = `<div class="preview-image-container">
        <div class="close-button" style="position: absolute; top: 0; right: 0; padding: 10px; cursor: pointer;">
            <i class="fas fa-times"></i>
        </div>
                        <div class="preview-image"></div>
                    </div>`;

        $('.fa-paperclip').on('click', function() {
            $('#gambar').click();
        });

        function imagePreview(fileInput) {
            if (fileInput.files && fileInput.files[0]) {
                var fileReader = new FileReader();
                fileReader.onload = function(event) {
                    $('.preview-image').css('background-image', `url(${event.target.result})`);
                };
                fileReader.readAsDataURL(fileInput.files[0]);
            }
        }


        $("#gambar").change(function() {
            $('.chatbox').append(imageBox);
            imagePreview(this);

            $('.close-button').on('click', function() {
                $('.preview-image-container').remove();
                $('#gambar').val('');
            });
        });

        function sendMessage() {

            var formData = new FormData();
            var image = $('#gambar')[0].files[0];
            var uid = $("input[name='user_id']").val();
            var message = $("#MessageText").val();

            formData.append('action', 'sendMessage');
            formData.append('message', message);
            formData.append('user_id', uid);
            formData.append('channel', thisChannel);
            formData.append('receiver_id', 1);
            formData.append('receiver_interest', "admin");
            formData.append('gambar', image);

            // $.post("<?= $view_public; ?>/chat/sendMessage", {
            //     action: 'sendMessage',
            //     message: message,
            //     user_id: uid,
            //     channel: thisChannel,
            //     receiver_id: 1
            // }, function(data) {
            //     console.log(data);
            // })

            $.ajax({
                type: "POST",
                url: "<?= $view_public ?>/chat/sendMessage",
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    $("#chatMessage").val('');
                    // hide image preview
                    $('.preview-image-container').addClass('d-none');
                }
            })
        }

        $("#form-send").submit(function(event) {
            event.preventDefault(); // mencegah form melakukan submit secara default
            sendMessage(); // memanggil fungsi sendMessage()
            $("#MessageText").val(''); // mengosongkan input text
            // kosongkan input file
            $('#gambar').val('');
        });

        // enter on keypress
        $("#MessageText").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                sendMessage();
                $("#MessageText").val('');
                // kosongkan input file
                $('#gambar').val('');
            }
        });

        // scroll to down of page
        function scrollToBottom() {
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        }

        // when scroll to top
        var chatKelipatan = 1;
        $('.chatbox').scroll(function() {
            var topContainer = $(this);
            var chatRoomID = $(this);
            var $id = $("input[name='user_id']").val();
            if ($(this).scrollTop() == 0) {
                chatKelipatan++;
                // bootstrap loader animation
                $('.chatbox').prepend('<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div></div>');

                var firstMessageID = $('.chatbox').find('.message-wrapper').first().data('id');
                console.log({
                    firstMessageID
                });

                $.post("<?= $view_public; ?>/chat/getChatUser", {
                    user_id: $id,
                    chatKelipatan: chatKelipatan
                }, function(data) {
                    $(chatRoomID).prepend(data);
                    // scroll to message yang sebelumnya paling atas (firstMessageID)
                    $(topContainer).scrollTop($(chatRoomID).find(`div[data-id="${firstMessageID}"]`).offset().top);

                    // bootstrap loader animation remove
                    $('.chatbox').find('.spinner-border').remove();
                });
            }
        });
    })
</script>