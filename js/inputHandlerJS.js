$(document).ready(function () {
    var txtVal;
    $('#inputID').keypress(function() {
        txtVal = this.value;
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
            alert("Error");
            return false;
        }
    }

    $('#myForm').submit(function () {
        if (!(validateURL(txtVal)))
        {
            return false;
        }
    });

    $(".links a").click(function(){
        var largePath = $(this).attr("href");
        var largeAlt = $(this).attr("title");
        $('#picture').attr({ src: largePath, alt: largeAlt });
        $('#picture').html(" (" + largeAlt + ") ");
        $('#picture').css("position", "absolute");
        $('#picture').css("left", "50%");
        //$('#picture').height()
        $('#picture').css("margin-left", "-470px");
        $('#picture').show();
        return false;
    });
    $('#picture').click(function(){
        $('#picture').hide();
    });
});
