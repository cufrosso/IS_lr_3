$("#register").on("click", function(){
    let reg_nick=$("#reg_nick").val().trim();
    if(reg_nick == ""){
        $("#reg_error").text("Введите никнейм");
        return false;
    }
    if (reg_nick.length > 32){
        $("#reg_error").text("Длина никнейма не должна превышать 32 символа");
        return false;
    }
    $("#reg_error").text("");

    $.ajax({
        url: "ajax/register.php",
        type: 'POST',
        cache: false,
        data: {'reg_nick': reg_nick},
        dataType: "html",
        beforeSend: function(){
            $("#register").prop("disabled", true);
        },
        success: function(data){
            if (data == 1) {
                $("#register").prop("disabled", false);
                window.location.href = 'chat.php';
            }
            else {
                $("#register").prop("disabled", false);
                $("#reg_error").text("Никнейм занят");
            }
        }
    });

});
