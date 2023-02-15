$(document).ready(function () {
    $('#photo').change( function(event) {
        var file = $("input[type=file]").get(0).files[0];
        if(file) {
            var reader = new FileReader();
            reader.onload = function(){
                $("#img-logo").attr("src", reader.result)
                    .addClass('logo')
                    .show();
                $("#div-logo").hide();
            }
            reader.readAsDataURL(file);
        }
    });
});
