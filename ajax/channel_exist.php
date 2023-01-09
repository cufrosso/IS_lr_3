<?php
    require_once "../config/connect.php";
    $channel = $_POST['channel'];
    $user = $_POST['user'];
    $exist = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM channels WHERE id = '$channel'"));
    if ($exist[0] == 1){
        echo 1;
    }
    else{
        echo 0;
    }
?>
