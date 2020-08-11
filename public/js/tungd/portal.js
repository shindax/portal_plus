$(function () {

    $("#radio").buttonset();
    $("input[type=submit], .button").button();
    $("select").selectmenu();


    $("#employee").autocomplete("/?task=autocomplete&f=findEmployee&ajax=1", {
        delay: 200,
        minChars: 3,
        autoFill: false,
        selectFirst: false,
        cacheLength: 0,
        max: 100
    });

    $("a.fancy").fancybox({
        'opacity': false,
        'transitionIn': 'elastic',
        'transitionOut': 'fade'
    });

    // $.get("/index.php", {task: 'incidents', f: 'viewLink', ajax: 1}, function (data) {
    //     $("li#serenalink").html(data);
    // });

    // поиск по нажатию enter
    $("#employee").keyup(function (event) {
        if (event.keyCode == 13) {
            $("form#employee_search").submit();
        }
    });

    $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 203,
        itemMargin: 0,
        pausePlay: true,
        start: function (slider) {
            $('body').removeClass('loading');
        }
    });

    $(".single_image").fancybox();

});

function go(location) {
    document.location.href = location;
}