<?php

require __DIR__ . '/../../../../public/assets/admin/vendor/autoload.php';

$app_id = "1576805";
$key = "c9ce2e95cbf7337b0b48";
$secret = "2341eaca8dd35a982e4b";
$cluster = "ap1";
$channel = "my-channel";
$limit = 100;

if ($_POST['action'] == 'sendMessage') {
    $channel2 = $_POST['channel'];
    $data['message'] = $_POST['message'];
    $data['user_id'] = $_POST['user_id'];
    $pusher = new Pusher\Pusher($key, $secret, $app_id, array('cluster' => $cluster));
    $pusher->trigger($channel2, 'send', $data);
}

// if ($_POST['action'] == 'joinChat') {
//     $data['user_id'] = $_POST['user_id'];
//     $pusher = new Pusher\Pusher($key, $secret, $app_id, array('cluster' => $cluster));
//     $pusher->trigger($channel, 'my-event', $data);
// }


// $options = array(
//     'cluster' => 'ap1',
//     'useTLS' => true
// );
// $pusher = new Pusher\Pusher(
//     'c9ce2e95cbf7337b0b48',
//     '2341eaca8dd35a982e4b',
//     '1576805',
//     $options
// );
// $data['user_id'] = $_POST['user_id'];
// $data['message'] = $_POST['message'];
// $pusher->trigger('my-channel', 'my-event', $data);
    

// if (isset($_POST['message'])) {
//     $data['message'] = $_POST['message'];
//     $pusher->trigger('my-channel', 'my-event', $data);
// }
