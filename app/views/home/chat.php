<?php
$view_public = "http://localhost/toko_vica/public";

if (!isset($_SESSION["id"])) {
    echo '<script>alert("Anda harus login terlebih dahulu");</script>';
    echo "<script>location.href = '" . URL . "/home';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link bootstrap  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- link jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register("<?= URL ?>/service-worker.js")
                .then(function(registration) {
                    console.log('Service worker successfully registered.');
                })
                .catch(function(error) {
                    console.log('Service worker registration failed:', error);
                });
        }
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: '56d09156-cdfb-4f41-9d32-fe3c822329ac',
        });
        var user_id = "<?= $_SESSION['id'] ?>";

        beamsClient.start()
            .then((beamsClient) => beamsClient.getDeviceId())
            .then((deviceId) =>
                console.log("Successfully registered with Beams. Device ID:", deviceId)
            )
            .then(() => beamsClient.removeDeviceInterest('admin')) // hapus semua device interest
            .then(() => beamsClient.addDeviceInterest("interest-" + user_id))
            .then(() => beamsClient.getDeviceInterests())
            .then((interests) => console.log("Current interests:", interests))
            .catch(console.error);
    </script>
    <title>Chat Page</title>
    <script>
        var pusher = new Pusher('c9ce2e95cbf7337b0b48', {
            cluster: 'ap1'
        });
        var thisChannel = 'channel' + "<?= $_SESSION['id'] ?>";
        var channel = pusher.subscribe(thisChannel);

        channel.bind('send', function(data) {
            var chatJoinnedMessage = '';
            var currentUserID = $("input[name='user_id']").val();

            if (data.user_id == currentUserID) {
                chatJoinnedMessage += '<div class="message-wrapper">';
                chatJoinnedMessage += '<span class="usernameis" style="align-self:flex-end">' + data.nama_user + '</span>';
                if (data.gambar != null) {
                    chatJoinnedMessage += `<div class="align-self-end">
                                    <img src="<?= $view_public; ?>/img/chat/${data.gambar}" alt="" width="200px" height="200px" style="object-fit: contain;">
                                </div>`;
                }
                chatJoinnedMessage += '<span class="sender-message">' + data.message + '</span>';
                chatJoinnedMessage += '</div>';
            } else {
                chatJoinnedMessage += '<div class="message-wrapper">';
                chatJoinnedMessage += '<span class="usernameis">' + data.nama_user + '</span>';
                if (data.gambar != null) {
                    chatJoinnedMessage += `<div class="">
                                    <img src="<?= $view_public; ?>/img/chat/${data.gambar}" alt="" width="200px" height="200px" style="object-fit: contain;">
                                </div>`;
                }
                chatJoinnedMessage += '<span class="receiver-message">' + data.message + '</span>';
                chatJoinnedMessage += '</div>';
            }

            $('.chatbox').append(chatJoinnedMessage);
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        });

        // bind succes subscribe
        channel.bind('pusher:subscription_succeeded', function(members) {
            console.log(thisChannel)
            console.log('Successfully subscribed!');
            // console.log(members);
        });
    </script>
    <?php include BASEURL . '/js/home_chat.php' ?>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/home_chat.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="mt-5 container customContainer">
        <input type="hidden" name="user_id" value="<?= $_SESSION['id']; ?>">
        <div class="chatbox">
            <?php foreach ($data['chat'] as $chat) {
            ?>
                <?php if ($chat['sender_id'] == $_SESSION['id']) { ?>
                    <div class="message-wrapper" data-id="<?= $chat['id_message']; ?>">
                        <span class="usernameis" style="align-self:flex-end"><?= $data['user']['nama_lengkap']; ?></span>
                        <?php if ($chat['image_path'] != null) { ?>
                            <div class="align-self-end">
                                <img src="<?= $view_public; ?>/img/chat/<?= $chat['image_path']; ?>" alt="" width="200px" height="200px" style="object-fit: contain;">
                            </div>
                        <?php } ?>
                        <span class="sender-message"><?= $chat['message']; ?></span>
                    </div>
                <?php } else { ?>
                    <div class="message-wrapper" data-id="<?= $chat['id_message']; ?>">
                        <span class="usernameis">admin</span>
                        <?php if ($chat['image_path'] != null) { ?>
                            <div class="">
                                <img src="<?= $view_public; ?>/img/chat/<?= $chat['image_path']; ?>" alt="" width="200px" height="200px" style="object-fit: contain;">
                            </div>
                        <?php } ?>
                        <span class="receiver-message"><?= $chat['message']; ?></span>
                    </div>

                <?php } ?>

            <?php } ?>
        </div>
        <form id="form-send" method="POST" enctype="multipart/form-data">
            <div class="mb-3 input-group">
                <input type="text" class="form-control w-75" id="MessageText" placeholder="Tulis Pesan Anda ...">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-paperclip fa-lg" style="cursor: pointer;"></i>
                        <input type="file" class="d-none" id="gambar" name="gambar">
                    </span>
                </div>
            </div>
            <button class="btn btn-primary" type="" onclick="return sendMessage()">Kirim Pesan</button>
        </form>
    </div>


    <script>
        // var uid = $("input[name='user_id']").val();
        // $.post("<?= BASEURL; ?>/admin/kirim", {
        // action: 'joinChat',
        // user_id: uid
        // }, function(data) {
        // console.log(data);
        // })
        // var imageBox = `<div class="preview-image-container">
        // <div class="close-button" style="position: absolute; top: 0; right: 0; padding: 10px; cursor: pointer;">
        //     <i class="fas fa-times"></i>
        // </div>
        //                 <div class="preview-image"></div>
        //             </div>`;

        // $('.fa-paperclip').on('click', function() {
        //     $('#gambar').click();
        // });

        // function imagePreview(fileInput) {
        //     if (fileInput.files && fileInput.files[0]) {
        //         var fileReader = new FileReader();
        //         fileReader.onload = function(event) {
        //             $('.preview-image').css('background-image', `url(${event.target.result})`);
        //         };
        //         fileReader.readAsDataURL(fileInput.files[0]);
        //     }
        // }


        // $("#gambar").change(function() {
        //     $('.chatbox').append(imageBox);
        //     imagePreview(this);

        //     $('.close-button').on('click', function() {
        //         $('.preview-image-container').remove();
        //         $('#gambar').val('');
        //     });
        // });

        // function sendMessage() {

        //     var formData = new FormData();
        //     var image = $('#gambar')[0].files[0];
        //     var uid = $("input[name='user_id']").val();
        //     var message = $("#MessageText").val();

        //     formData.append('action', 'sendMessage');
        //     formData.append('message', message);
        //     formData.append('user_id', uid);
        //     formData.append('channel', thisChannel);
        //     formData.append('receiver_id', 1);
        //     formData.append('receiver_interest', "admin");
        //     formData.append('gambar', image);

        //     // $.post("<?= BASEURL; ?>/chat/sendMessage", {
        //     //     action: 'sendMessage',
        //     //     message: message,
        //     //     user_id: uid,
        //     //     channel: thisChannel,
        //     //     receiver_id: 1
        //     // }, function(data) {
        //     //     console.log(data);
        //     // })

        //     $.ajax({
        //         type: "POST",
        //         url: "<?= BASEURL ?>/chat/sendMessage",
        //         enctype: 'multipart/form-data',
        //         contentType: false,
        //         processData: false,
        //         data: formData,
        //         success: function(data) {
        //             $("#chatMessage").val('');
        //             // hide image preview
        //             $('.preview-image-container').addClass('d-none');
        //         }
        //     })
        // }

        // $("#form-send").submit(function(event) {
        //     event.preventDefault(); // mencegah form melakukan submit secara default
        //     sendMessage(); // memanggil fungsi sendMessage()
        //     $("#MessageText").val(''); // mengosongkan input text
        // });

        // // enter on keypress
        // $("#MessageText").keypress(function(e) {
        //     if (e.which == 13) {
        //         e.preventDefault();
        //         sendMessage();
        //         $("#MessageText").val('');
        //     }
        // });
    </script>
</body>

</html>