<?php

    include "Classes/Guest.php";
    if (count($_POST) == 0) {
        return;
    }
    $user_data = $_POST;
    $user_data["ip"] = $_SERVER["REMOTE_ADDR"];
    $user_data["dt"] = date("Y-m-d_H:i:s");
    $user = new Guest($user_data);
    $user->save();
    echo "Заявка принята!";