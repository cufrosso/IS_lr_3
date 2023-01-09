<?php
    require_once "../config/connect.php";

    $nick = $_POST["reg_nick"];
    $exist = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM users WHERE nickname = '$nick'"));
    if ($exist[0] == 1){
        echo 0;
    }
    else{
        mysqli_query($connect,"INSERT INTO users (id, nickname) values(NULL, '$nick')");
        session_start();
        $_SESSION['nick'] = $nick;
        echo 1;
    }
?>