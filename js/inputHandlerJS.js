$(document).ready(function () {
    $(":input").css("font-size", "25px");
    $(':input').change(function (eventObject) {
        $.post("index.php", { data: data });
    });
});
