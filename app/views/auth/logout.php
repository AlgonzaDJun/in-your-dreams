<?php
$_SESSION = [];
session_unset();
session_destroy();

setcookie('id', '', time() + 3600 * 12, '/toko_vica', 'localhost', false, true);
?>
<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script>
    const beamsClient = new PusherPushNotifications.Client({
        instanceId: '56d09156-cdfb-4f41-9d32-fe3c822329ac',
    });

    // beamsClient.start()
    //     .then(() => beamsClient.getDeviceInterests())
    //     .then((interests) => beamsClient.removeDeviceInterest(`${interests}`))
    //     .then(() => {
    //         console.log('Device interests cleared');
    //     })
    async function clearDeviceInterests() {
        await beamsClient.start();
        const interests = await beamsClient.getDeviceInterests();
        await beamsClient.removeDeviceInterest(`${interests}`);
        // remove device interest-3, arjun
        await beamsClient.removeDeviceInterest(`interest-3`);
        await beamsClient.removeDeviceInterest(`arjun`);
        console.log('Device interests cleared');
    }
</script>

<script>
    clearDeviceInterests()
        .then(() => {
            console.log('Redirecting to login page');
            location.href = '<?= URL ?>/login';
        })
        .catch((error) => {
            console.error('Error clearing device interests:', error);
            location.href = '<?= URL ?>/login';
        });
</script>