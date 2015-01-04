$(function() {
    $('input[type=file]').bootstrapFileInput();

    $("textarea#SecufileContent").keyup(function() {
        $(this).text($(this).val())
    });

});
