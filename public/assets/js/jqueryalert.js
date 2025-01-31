$(document).ready(function () {
    $('input[name="capacity"]').on("input", function () {
        var value = $(this).val();
        if (value < 1 && value !== "") {
            $("#alert").show();
            $(this).val("");
        } else {
            $("#alert").hide();
        }
    });
});
