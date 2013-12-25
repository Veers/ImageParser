$(document).ready(function () {
    var txtVal;
    $('#inputID').keypress(function() {
        txtVal = $(this).val();
    });

    function validateURL(param){
        var prefix = param.indexOf("://");
        if (prefix != -1)
        {
            param = param.substr(prefix + 3); // lenght of :// symbols
        }
        var piecesOfURL = param.split('/');
        var domain = piecesOfURL[0];
        if (domain.indexOf('.') != -1)
        {
            return true;
        } else {
            alert(txtVal+" не является ссылкой");
            return false;
        }
    }

    $('#myForm').submit(function () {
        if (!(validateURL(txtVal)))
        {
            return false;
        }
    });

    $(".links a").click(function(e){
        var largePath = $(this).attr("href");
        var largeAlt = $(this).attr("title");
        var $picture = $('#picture');
        $picture.attr({ src: largePath, alt: largeAlt });
        $picture.html(" (" + largeAlt + ") ");
        $picture.css("visibility", "visible");
//        $('#picture').show();
        var $img = $('img');
        $img.load(function(){
            $(this).removeAttr("width").removeAttr("height").css({ width: "", height: "" });
            var width  = $(this).width();
            var height = $(this).height();
            $("#divblock").css("width", width+10);
            $("#divblock").css("height", height+10);
        });
        var overlay = $("#overlay");
        var w = document.body.scrollWidth + 'px';
        var h = document.body.scrollHeight + 'px';
        overlay.css('width', w);
        overlay.css('height', h);
        overlay.css('display','block');
        // $("#divblock").css('top','400');
        var top_coords = $(window).scrollTop();
        var coords = top_coords + (($(window).height()/2) - $('divblock').height());
        //alert($(window).height());//387
        $("#divblock").css({margin: coords+'px 0px 0px -300px', 'top': '0'});
        $("#divblock").css('display','block');
        e.preventDefault();
    });

    $('#picture').click(function(){
        $("#overlay").css('display','none');
        $("#divblock").css('display','none');
    });
});
