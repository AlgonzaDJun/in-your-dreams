<?php include 'authentication.php' ?>

<!-- buat style sederhana tata letak di tengah -->
<style>
    .login {
        /* width: 100%; */
    }

    body {
        background-color: #537188;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        /* width: 100%; */
    }

    form {
        margin: auto;
        width: 500px;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #4B8673;
    }

    @media screen and (max-width: 760px) {
        form {
            width: 100%;
        }
    }


    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 5px;
        border: 1px solid #eee;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    button {
        width: 100%;
        padding: 5px;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #eee;
        cursor: pointer;
    }

    button:hover {
        background-color: #ddd;
    }

    button:active {
        background-color: #ccc;
    }

    button:focus {
        outline: none;
    }

    .error {
        color: red;
    }

    .success {
        color: green;
    }

    .info {
        color: blue;
    }

    .warning {
        color: orange;
    }

    .message {
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
    }
    .pesan {
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        font-size: large;
        font-weight: bold;
    }
</style>


<div class="login">
    <?php if (isset($data['error'])) { ?>
        <h1><?= $data['error']; ?></h1>
    <?php } ?>
    <form action="<?= URL; ?>/login/login" method="post">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <br>
        <button type="submit" name="login">Login</button>
    </form>
    <div class="pesan">
        <!-- belum punya akun? register -->
        <p>Belum punya akun? <a href="<?= URL; ?>/register" style="color: white">Register</a></p>
    </div>
</div>