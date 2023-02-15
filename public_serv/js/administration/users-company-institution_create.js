$(document).ready(function () {
    //enable password for update
    $('#swEnablePassword').click(function(event) {
        if($(this).prop("checked") == true)
            $('#password').prop('disabled', false);
        else
            $('#password').prop('disabled', true);
    });
});
