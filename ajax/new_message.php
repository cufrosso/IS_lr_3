<?php
    require_once "../config/connect.php";

    $channel_id = $_POST["channel_id"];
    $message = $_POST["message"];
    $user = $_POST["user"];
    $time = time() + 3*60*60;
    mysqli_query($connect, "INSERT INTO messages (`id`, `channel_id`, `message`, `user`, `time`) VALUES (NULL, '$channel_id', '$message', '$user', '$time')");
    mysqli_query($connect, "UPDATE channels SET last_message_time='$time' WHERE id = '$channel_id'");
    echo 1;
?>
