<style>
    .btn-login {
        /* background green */
        background-color: #28a745;
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: #218838;
    }
</style>

<main role="main" class="container">

    <!-- logout button in top right page -->
    <?php if (isset($_COOKIE['id'])) : ?>
        <div class="mt-2 w-100 d-flex justify-content-end">
            <div class="">
                <a href="<?= URL; ?>/login/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- buat landing page bootstrap 4 -->
    <div class="mt-3">
        <h1 class="display-4">In Your Dreams!</h1>
        <p class="lead font-weight-bold font">Website Fashion yang dikembangkan untuk pecinta fashion.</p>
        <hr class="my-4">
    </div>

    <?php if (!isset($_COOKIE['id'])) : ?>
        <div class="mt-2">
            <div class="col-md-6">
                <a href="<?= URL; ?>/login" class="btn btn-login">Login</a>
            </div>
        </div>

        <div class="mt-2">
            <div class="col-md-6">
                <a href="<?= URL; ?>/register" class="btn" style="background-color: #DC5F00; color:white">Register</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- buat button chat -->
    <div class="mt-2">
        <div class="col-md-6">
            <a href="<?= URL; ?>/home/chat" class="btn btn-primary">Buka Chat</a>
        </div>
    </div>

</main>