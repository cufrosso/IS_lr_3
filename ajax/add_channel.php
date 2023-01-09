<?php
    require_once "../config/connect.php";

    $creator = $_POST['creator'];
    $name = $_POST['name'];

    $exist = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM channels WHERE `name` = '$name'"));
    if ($exist[0] == 1){
        echo 0;
    }
    else {
        $time = time() + 3*60*60;
        mysqli_query($connect, "INSERT INTO channels (`id`, `name`, `creator`, `last_message_time`) VALUES (NULL, '$name', '$creator', '$time')");
        echo 1;
    }
?>
