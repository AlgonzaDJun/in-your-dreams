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