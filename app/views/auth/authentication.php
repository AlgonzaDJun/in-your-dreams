<?php

if (isset($_SESSION["id"])) {
    if($_SESSION["role"] == "admin") {
        echo "<script>location.href = '" . URL . "/admin';</script>";
        exit;
    } else {
        echo "<script>location.href = '" . URL . "/home';</script>";
        exit;
    }
};
