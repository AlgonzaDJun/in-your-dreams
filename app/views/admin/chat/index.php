<head>
    <style>
        .chat-container {
            height: 380px;
            overflow-y: scroll;
            position: relative;
        }

        .list-unstyled {
            height: 100%;
        }

        @media only screen and (max-width: 768px) {
            #chat_mobile {
                height: 380px;
                overflow-y: scroll;
            }
        }

        .content-center-absolute {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        input[type="file"] {
            position: absolute;
            width: 0;
            height: 0;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        input[type="file"]+label {
            cursor: pointer;
        }

        /* CSS untuk preview image */
        .preview-image-container {
            position: sticky;
            top: 0;
            left: 0;
            height: calc(100% - 1px);
            width: 73%;
            float: left;
            margin-right: -100%;
            /* height: 100%;
            width: 100%;
            position: absolute; */
            bottom: 0;
            /* left: 0; */
            right: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: block;
            border-radius: 5px;
        }

        .preview-image {
            border-radius: 10px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate3d(-50%, -50%, 0);
            /* background-color: rgba(0, 0, 0, 0.4); */
            /* position: sticky; */
            width: 459px;
            height: 0;
            padding-top: 72%;
            /* asumsi aspek rasio gambar adalah 4:3 */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
        }

        @media only screen and (max-width: 768px) {
            .preview-image-container {
                width: calc(100% - 1px);
            }

            .preview-image {
                left: 50%;
                height: 100%;
                width: 315px;
                padding-top: 57%;
            }
        }

        .bg-pattern {
            background-color: #e5e5f7;
            opacity: 0.8;
            background: linear-gradient(135deg, #444cf755 25%, transparent 25%) -10px 0/ 20px 20px, linear-gradient(225deg, #444cf7 25%, transparent 25%) -10px 0/ 20px 20px, linear-gradient(315deg, #444cf755 25%, transparent 25%) 0px 0/ 20px 20px, linear-gradient(45deg, #444cf7 25%, #e5e5f7 25%) 0px 0/ 20px 20px;
        }
    </style>

    <?php
    include BASEURL . '/assets/admin/js/js_chatt.php';

    ?>
    <!-- <script src="<?= BASEURL; ?>/assets/admin/vendor/service-worker.js"></script> -->

    <script>
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: '56d09156-cdfb-4f41-9d32-fe3c822329ac',
        });

        beamsClient.start()
            .then((beamsClient) => beamsClient.getDeviceId())
            .then((deviceId) =>
                console.log("Successfully registered with Beams. Device ID:", deviceId)
            )
            .then(() => beamsClient.addDeviceInterest("admin"))
            .then(() => beamsClient.getDeviceInterests())
            .then((interests) => console.log("Current interests:", interests))
            .catch(console.error);
    </script>
</head>



<section style="background-color: #eee;">
    <div class="container-fluid py-5">

        <input type="hidden" name="session_id" value="<?= $_SESSION['id']; ?>">

        <div class="d-none d-sm-block d-md-none" id="back-chat-room">
            <!-- fa back -->
            <a href="#" onclick="return backToChat()" id="back-button-mb" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i></a>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0" id="chat_mobile">
                <!-- button send notif -->
                <!-- <button class="btn btn-primary mb-3" onclick="return sendNotification()">Send Notification</button> -->
                <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($data['unread_chat'] as $user) { ?>
                                <li class="p-2 my-3 border-bottom" style="background-color: #eee;">
                                    <a href="Javascript:void(0)" class="text-decoration-none d-flex justify-content-between" onclick="return changeChatRoom(<?= $user['user_id'] ?>)">
                                        <div class="d-flex flex-row">
                                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1 ml-2">
                                                <p class="fw-bold mb-0"><?= $user['sender_name']; ?></p>
                                                <p class="small text-muted"><?= $user['message']; ?></p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1"><?= $user['created_at']; ?></p>
                                            <span class="badge bg-danger float-end"><?= $user['total_unread']; ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>
                </div>

            </div>

            <div class="d-none d-md-block col-md-6 col-lg-7 col-xl-8 chat-container bg-white" style="padding: 15px;
    border-radius: 10px 0 0 0;">
                <ul class="list-unstyled" id="chat_user">
                    <div class="content-center-absolute">
                        <h1>Pilih Chat</h1>
                    </div>
                </ul>
                <!-- <div class="preview-image-container">
                    <div class="preview-image"></div>
                </div> -->
            </div>
        </div>

        <div class="row justify-content-end d-none" id="chat-send">
            <div class="col-md-6 col-lg-7 col-xl-8 mb-4 mb-md-0 pt-md-5 float-md-right w-100 bg-white" style="border-radius: 0 0 10px 10px;">
                <li class="mb-2" style="list-style: none;">
                    <div class="form-outline d-flex">
                        <div class="input-group">
                            <input class="form-control w-75" placeholder="silakan ketik pesan anda" id="chatMessage"></input>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-paperclip fa-lg" style="cursor: pointer;"></i>
                                    <input type="file" class="d-none" id="gambar" name="gambar" required>
                                </span>
                            </div>
                        </div>
                        <button type="button" class="ml-2 btn btn-info btn-rounded float-end w-25 p-2" onclick="return sendMessage()">Send</button>
                    </div>
                </li>

            </div>
        </div>

    </div>
</section>