<style>
    .bubble-chat {
        border-radius: 20px;
    }

    .no-message {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<?php
// if $data['chat'] is empty
if (empty($data['chat'])) {
    echo '<p class="text-center no-message">Belum ada pesan</p>';
}

?>

<?php foreach ($data['chat'] as $chat) {
    $db_timestamp = strtotime($chat['created_at']);

    $current_timestamp = time();
    $time_difference = $current_timestamp - $db_timestamp;
    $minutes = round($time_difference / 60);
    // if lebih dari 1 jam maka tampilkan jam
    if ($minutes > 60) {
        $hours = round($minutes / 60);
        if ($hours > 24) {
            $days = round($hours / 24);
            $time_string = $days . ' hari yang lalu';
        } else {
            $time_string = $hours . ' jam yang lalu';
        }
    } else {
        $time_string = round($minutes / 60) . ' menit yang lalu';
    }

?>
    <?php if ($chat['sender_id'] != $_SESSION['id']) { ?>
        <li class="d-flex mb-4" data-id="<?= $chat['id_message']; ?>">
            <div class="card bubble-chat">
                <div class="card-header d-flex justify-content-between" style="border-radius: 20px;">
                    <p class="fw-bold mb-0"><?= $data['user']['nama_lengkap'] ?></p>
                    <p class="text-muted small mb-0"><i class="far fa-clock"></i> <?= $time_string; ?></p>
                </div>
                <?php if (($chat['image_path']) !== null) { ?>
                    <div class="">
                        <a href="<?= BASEURL; ?>/img/chat/<?= $chat['image_path']; ?>" data-pswp-width="1200" data-pswp-height="1200">
                            <img src="<?= BASEURL; ?>/img/chat/<?= $chat['image_path']; ?>" alt="" width="200px" height="200px" style="object-fit: contain;">
                        </a>
                    </div>
                <?php } ?>
                <div class="card-body">
                    <p class="mb-0">
                        <?= $chat['message'] ?>
                    </p>
                </div>
            </div>
        </li>
    <?php } else { ?>
        <li class="d-flex justify-content-end mb-4" data-id="<?= $chat['id_message']; ?>">
            <div class="card bubble-chat">
                <div class="card-header d-flex justify-content-between p-3" style="border-radius: 20px;">
                    <p class="fw-bold mb-0">Admin</p>
                    <p class="text-muted small mb-0"><i class="far fa-clock"></i> <?= $time_string; ?></p>
                </div>
                <?php if (($chat['image_path']) !== null) { ?>
                    <div class="">
                        <a href="<?= BASEURL; ?>/img/chat/<?= $chat['image_path']; ?>" data-pswp-width="1200" data-pswp-height="1200">
                            <img src="<?= BASEURL; ?>/img/chat/<?= $chat['image_path']; ?>" alt="" width="200px" height="200px" style="object-fit: cover;">
                        </a>
                    </div>
                <?php } ?>
                <div class="card-body">
                    <p class="mb-0">
                        <?= $chat['message'] ?>
                    </p>
                </div>
            </div>
        </li>
    <?php } ?>

<?php } ?>