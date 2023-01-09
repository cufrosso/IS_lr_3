<?php
    session_start();
    if (!isset($_SESSION['nick'])){
        header("location: registration.php");
    }
    $nick = $_SESSION['nick'];
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    let active_channel = null;
    let user = '<?php echo $nick?>';
    let messages_data = null;
    let channels_data = null;

    function add_channel(){
        let name = prompt('Введите название');
        if (name == null || name.trim() == ""){
            alert("Введено пустое поле");
            return 0;
        }
        if (name.length > 32){
            alert("Максимальная длина названия - 32 символа");
            return 0;
        }

        $.ajax({
            url: "ajax/add_channel.php",
            type: "POST",
            cache: false,
            data: {"name": name, "creator": user},
            dataType: "html",
            success: function (data) {
                if (data == "1") {
                    load_channels();
                }
                else{
                    alert("Канал с таким названием уже существует");
                }
            }
        });
    }

    function load_channels(){
        $.ajax({
            url: "ajax/load_channels.php",
            type: "POST",
            cache: false,
            data: {"user": user},
            dataType: "html",
            success: function (data) {
                if (channels_data != data) {
                    channels_data = data;
                    $("#channels").empty();
                    $("#channels").append(data);
                    $.ajax({
                        url: "ajax/channel_exist.php",
                        type: "POST",
                        cache: false,
                        data: {"channel": active_channel, "user": user},
                        dataType: "html",
                        success: function(exist){
                            if (exist == '1') {
                                $("#" + active_channel).prop("disabled", true);
                            }
                            else{
                                active_channel = null;
                            }
                        }
                    });
                }
            }
        });
    }

    function open_channel(id){
        if (active_channel != null) {
            $("#" + active_channel).prop("disabled", false);
        }
        active_channel = id;
        $("#" + id).prop("disabled", true);
        $("#send").prop("disabled", false);

        $.ajax({
            url: "ajax/open_channel.php",
            type: "POST",
            cache: false,
            data: {"channel_id": id},
            dataType: "html",
            success: function(data){
                if (messages_data != data) {
                    messages_data = data;
                    $("#messages").empty();
                    $("#messages").append(data);
                    $("#messages").scrollTop(10000);
                }
            }
        });
    }

    function send_message(){
        let message = $("#new_message").val();
        $.ajax({
            url: "ajax/new_message.php",
            type: "POST",
            cache: false,
            data: {"channel_id": active_channel, "message": message, "user": user},
            dataType: "html",
            success: function(data){
                open_channel(active_channel);
                $("#new_message").val('');
            }
        });
    }

    load_channels();
</script>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Чат</title>
</head>
<body>

    <div class="container">
        <form action="config/exit.php">
            <h5 style="margin-left:-65px; margin-top:30px">
                <button type="submit" class="btn btn-outline-danger" style="margin-right:5px;">Выход</button>
                <?php echo $nick; ?>
            </h5>
        </form>
    </div>

    <div class="container">
        <div class="row">
            <div class="col"><br><br>
                <div id="channels" class="btn-group-vertical" style="margin-left:-65px"></div>
            </div>
            <div class="col-7"><br><br>
                <table class="table table-bordered table-secondary">
                    <tr>
                        <th scope="col">
                            <div id="messages" style="height:400px; overflow: auto"></div>
                        </th>
                    </tr>
                </table>
                <form class="btn-group container-fluid">
                    <input type="text" id="new_message" placeholder="Сообщение" class="form-control"><br>
                    <button type="button" id="send" class="btn btn-outline-success" onclick="send_message()">Отправить</button>
                </form>
            </div>
          </div>
    </div>

    <script>
        $("#send").prop("disabled", true);
        setInterval(function(){
            load_channels();
            if (active_channel != null) {
                open_channel(active_channel);
            }
            else{
                $("#send").prop("disabled", true);
                $("#messages").empty();
            }
        }, 2000);
    </script>

</body>
</html>
