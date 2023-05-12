<?php  ?>

<script>
    var pusher = new Pusher('c9ce2e95cbf7337b0b48', {
        cluster: 'ap1'
    });

    // buat subscribe secara dinamis tergantung pada user_id
    var channel = pusher.subscribe('channel-' + $("input[name='user_id']").val());

    channel.bind('send', function(data) {
        var chatJoinnedMessage = '<small?>User ID ' + data.user_id + '</small>' + '<br>' + '<p>' + data.message + '</p>';
        $('.chatbox').append(chatJoinnedMessage);
    });

    function sendMessage() {
        var uid = $("input[name='user_id']").val();
        var message = $("#MessageText").val();
        $.post("<?= URL; ?>/chat/sendMessage", {
            action: 'sendMessage',
            message: message,
            user_id: uid
        }, function(data) {
            // console.log(data);
        })
    }

    $("#form-send").submit(function(event) {
        event.preventDefault(); // mencegah form melakukan submit secara default
        sendMessage(); // memanggil fungsi sendMessage()
        $("#MessageText").val(''); // mengosongkan input text
    });

    // enter on keypress
    $("#MessageText").keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            sendMessage();
            $("#MessageText").val('');
        }
    });

    function changeChatRoom($id) {
        $.post("<?= URL; ?>/chat/getChatBySenderId", {
            action: 'getChatBySenderId',
            user_id: $id
        }, function(data) {

        })
    }
</script>