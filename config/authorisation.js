$("#authorisation").on("click", function(){
    let auth_nick=$("#auth_nick").val().trim();
    if(auth_nick == ""){
        $("#auth_error").text("Введите никнейм");
        return false;
    }
    $("#auth_error").text("");

    $.ajax({
        url: "ajax/authorisation.php",
        type: 'POST',
        cache: false,
        data: {'auth_nick': auth_nick},
        dataType: "html",
        beforeSend: function(){
            $("#authorisation").prop("disabled", true);
        },
        success: function(data){
            if (data == 1) {
                $("#authorisation").prop("disabled", false);
                window.location.href = 'chat.php';
            }
            else {
                $("#authorisation").prop("disabled", false);
                $("#auth_error").text("Пользователя с таким ником не существует");
            }
        }
    });

});
