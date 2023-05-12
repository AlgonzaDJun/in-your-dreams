<?php
$view_admin = "http://localhost/toko_vica/app/views/admin/";
$view_public = "http://localhost/toko_vica";
$url_public = "http://localhost/toko_vica/public";
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

    var session_id = $('input[name="session_id"]').val();

    var receiver_id = 0;

    var topContainer = '.chat-container';

    var chatRoomID = '#chat_user';
    if (window.innerWidth <= 768) { // menentukan apakah tampilan mobile atau tidak
        chatRoomID = '#chat_mobile';
        var previousChannel = null;
        topContainer = '#chat_mobile';
    }

    var lightbox = new PhotoSwipeLightbox({
        gallery: chatRoomID,
        children: 'a',
        // dynamic import is not supported in UMD version
        pswpModule: PhotoSwipe
    });
    lightbox.init();

    var pusher = new Pusher('c9ce2e95cbf7337b0b48', {
        cluster: 'ap1'
    });

    var previousChannel = null;

    function changeChatRoom($id) {

        console.log('previous channel : ' + previousChannel);

        var thisChannel = 'channel' + $id;
        if (previousChannel != null && previousChannel != thisChannel) {
            pusher.unsubscribe(previousChannel);
        }

        $('#back-chat-room').removeClass('d-none');
        $('#chat-send').removeClass('d-none');
        // $('#back-chat-room').addClass('d-sm-block');

        $.post("<?= $view_public; ?>/chat/getChatBySenderId", {
            action: 'getChatBySenderId',
            user_id: $id
        }, function(data) {
            $(chatRoomID).html(data);
            // scroll to bottom of chatRoomID
            $('.chat-container').animate({
                scrollTop: $('.chat-container').prop('scrollHeight')
            }, 1000);

            if (window.innerWidth <= 768) {
                // menentukan apakah tampilan mobile atau tidak
                $(chatRoomID).animate({
                    scrollTop: $(chatRoomID).prop('scrollHeight')
                }, 1000);
            }
        });

        // if previousChannel is null, then subscribe to new channel
        if (previousChannel == null) {
            var channel = pusher.subscribe('channel' + $id);
        } else if (previousChannel != thisChannel) {
            var channel = pusher.subscribe('channel' + $id);
        } else if (previousChannel == thisChannel) {
            return;
        }

        channel.bind('send', function(data) {

            const date = new Date();
            const hours = date.getHours();
            const minutes = date.getMinutes();

            if (data.user_id != session_id) {
                var chatMessage = `<li class="d-flex mb-4">
                        <div class="card bubble-chat">
                            <div class="card-header d-flex justify-content-between" style="border-radius: 20px;">
                                <p class="fw-bold mb-0">${data.nama_user}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${hours}:${minutes}</p>
                            </div>`;
                if (data.gambar != null) {
                    chatMessage += `<div class="">
                                    <img src="<?= $url_public; ?>/img/chat/${data.gambar}" alt="" width="200px" height="200px" style="object-fit: contain;">
                                </div>`;
                }
                chatMessage += `<div class="card-body">
                                <p class="mb-0">${data.message}</p>
                            </div>
                        </div>
                    </li>`;
            } else {
                var chatMessage = `<li class="d-flex justify-content-end mb-4">
                        <div class="card bubble-chat">
                            <div class="card-header d-flex justify-content-between p-3" style="border-radius: 20px;">
                                <p class="fw-bold mb-0">Admin</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${hours}:${minutes} </p>
                            </div>`;
                if (data.gambar != null) {
                    chatMessage += `<div class="">
                                    <img src="<?= $url_public; ?>/img/chat/${data.gambar}" alt="" width="200px" height="200px" style="object-fit: contain;">
                                </div>`;
                }
                chatMessage += `<div class="card-body">
                                <p class="mb-0">${data.message}</p>
                            </div>
                        </div>
                    </li>`;
            }

            console.table(data);
            $(chatRoomID).append(chatMessage);
            $('.chat-container').animate({
                scrollTop: $('.chat-container').prop('scrollHeight')
            }, 1000);

            if (window.innerWidth <= 768) {
                // menentukan apakah tampilan mobile atau tidak
                $(chatRoomID).animate({
                    scrollTop: $(chatRoomID).prop('scrollHeight')
                }, 1000);
            }

        })

        // bind success subscribe
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('subscribed to channel : ' + 'channel' + $id);
        });

        channel.bind("pusher:subscription_count", (data) => {
            console.log('data : ' + data.subscription_count);
            // console.log('chanel : ' + channel.subscription_count);
        });

        previousChannel = thisChannel;
        receiver_id = $id;

        if (window.innerWidth <= 768) {
            previousChannel = thisChannel;
        }

        $('#back-button-mb').attr('data-id', $id);

        // console.log('current channel : ' + thisChannel);

        var chatKelipatan = 1;
        // saat scroll ke atas, maka akan mengambil data sebelumnya
        $(topContainer).scroll(function() {
            if ($(this).scrollTop() == 0) {
                chatKelipatan++;

                // bootstrap loader animation
                $(topContainer).prepend('<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div></div>');

                var firstMessageID = $(chatRoomID).find('li').first().data('id');


                $.post("<?= $view_public; ?>/chat/getChatBySenderId", {
                    user_id: $id,
                    chatKelipatan: chatKelipatan
                }, function(data) {
                    $(chatRoomID).prepend(data);
                    // scroll to message yang sebelumnya paling atas (firstMessageID)
                    $(topContainer).scrollTop($(chatRoomID).find(`li[data-id="${firstMessageID}"]`).offset().top);

                    // bootstrap loader animation remove
                    $(topContainer).find('.spinner-border').remove();
                });

            }
        });
    }

    function backToChat() {
        var id = $('#back-button-mb').data('id');
        var channel = 'channel' + id;
        pusher.unsubscribe(channel);
        // alert(channel);
        changeContent('chat');
    }

    $('#back-chat-room').click(function() {
        // $('#back-chat-room').removeClass('d-sm-block');
        $('#back-chat-room').addClass('d-none');
        $('#chat-send').addClass('d-none');
    })

    function sendMessage() {
        var formData = new FormData();
        var image = $('#gambar')[0].files[0];


        var uid = $("input[name='user_id']").val();
        var message = $("#chatMessage").val();
        var receiver_interest = 'interest-' + receiver_id;

        formData.append('action', 'sendMessage');
        formData.append('message', message);
        formData.append('user_id', session_id);
        formData.append('channel', previousChannel);
        formData.append('receiver_id', receiver_id);
        formData.append('receiver_interest', receiver_interest);
        formData.append('gambar', image);

        // $.post("<?= $view_public ?>/chat/sendMessage", {
        //     action: 'sendMessage',
        //     message: message,
        //     user_id: session_id,
        //     channel: previousChannel,
        //     receiver_id: receiver_id
        // }, function(data) {
        //     $("#chatMessage").val('');
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
        $("#chatMessage").val(''); // mengosongkan input text
    });

    // enter on keypress
    $("#chatMessage").keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            sendMessage();
            $("#chatMessage").val('');
        }
    });

    var imageBox = `<div class="preview-image-container">
                        <div class="preview-image"></div>
                    </div>`;

    $('.fa-paperclip').on('click', function() {
        $('#gambar').click();

        // $('.preview-image-container').css('top', $(chatRoomID).prop('scrollHeight') - 320);
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
        $(chatRoomID).append(imageBox);
        imagePreview(this);
    });

    function sendNotification() {
        $.ajax({
            type: "POST",
            url: "<?= $view_public ?>/chat/sendNotification",
            data: {
                action: 'sendNotification',
                user_id: session_id,
                receiver_id: receiver_id
            },
            success: function(data) {
                console.log(data);
            }
        })
    }
</script>