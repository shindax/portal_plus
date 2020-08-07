/**
 * Глобальная асинхронная функция обращения ко внутренним компонентам средствами Ajax
 */
function doAjax(args) {
    var result;
    try {
        result = $.ajax({
            url: 'index.php',
            type: 'POST',
            dataType: 'text',
            data: args
        });
        return result;
    } catch (error) {
        console.error(error);
    }
}

/** Реально в js нет нормальной функции форматирования даты?! */
function stringDate(date) {
    var date = new Date(date);
    var mm = date.getMonth()+1;
    mm = (mm<10?"0"+mm:mm);
    var dd = date.getDate();
    dd = (dd<10?"0"+dd:dd);
    return dd+'.'+mm+'.'+date.getFullYear();
}

$(window).on("load", function () {

    $(function () {

        $('#employee').on('input', function (e) {
            var str = $(this).val();
            str = str.replace('ё', 'е').replace('Ё', 'Е');
            $(this).val(str);
        });

        // Поиск сотрудников в справочнике на Ajax
        $('#employee').autocomplete({
            minChars: 3,
            maxHeight: 500,
            serviceUrl: '/?task=autocomplete&f=findEmployee&ajax=1&mode=json',
            type: 'GET',
            dataType: 'text',
            paramName: 'q',
            onSelect: function (suggestion) {
                $("form#employee_search").submit();
            }
        });

        // Поиск сотрудников в справочнике на Ajax
        $('#footer_employee').autocomplete({
            minChars: 3,
            maxHeight: 200,
            serviceUrl: '/?task=autocomplete&f=findEmployee&ajax=1&mode=json',
            type: 'GET',
            dataType: 'text',
            paramName: 'q',
            onSelect: function (suggestion) {
                $("form#footer_employee_search").submit();
            }
        });

        // Поиск сотрудников в справочнике на Ajax
        $('#invoice-curator_id').autocomplete({
            minChars: 3,
            maxHeight: 200,
            serviceUrl: '/?task=autocomplete&f=findEmployee&ajax=1&mode=json',
            type: 'GET',
            dataType: 'text',
            paramName: 'q'
            // , onSelect: function (suggestion) {
            //     $("form#footer_employee_search").submit();
            // }
        });

    });

    function go(location) {
        document.location.href = location;
    }

    /* Добавить стиль selectedLink ссылке, совпадающей с нынешней страницей */
    var getLocation = function (href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };
    var l = getLocation(window.location);
    var query_link = "a[href$='" + l.pathname + "']";
    $(query_link).addClass("selectedLink");

    if ((l.pathname.indexOf('/news/feed') != -1)) {
        $("a[href='/News']").addClass("selectedLink");
    }

    /**
     * Автоматически обновляем время на главной странице, проверка времени каждую секунду
    */
    function getFormattedDate() {
        var date = new Date();
        var str = date.getHours() + ":" + ((date.getMinutes() < 10 ? '0' : '') + date.getMinutes())/* + ":" + date.getSeconds() */;
        return str;
    }
    function refreshingTimeOnMainPage() {
        var startTime = getFormattedDate();
        var timerId = setInterval(function () {
            nowTime = getFormattedDate();
            if (startTime != nowTime) {
                $('.time_refresh_auto').html(nowTime);
                startTime = nowTime;
            }
        }, 1000);
    }
    refreshingTimeOnMainPage();

});

/**
 * Функция загружает поддиректорию, сворачивает/разворачивает директорию при доп кликах
 */
$(document).on('click', '.ld_dirs_item > a', function (e) {
    dir = $(this).attr('href');
    myLi = $(this).closest('li');
    if (!myLi.hasClass('loaded')) {
        myLi.append('<span class="child_list">&nbsp;&nbsp;<i class="fa fa-refresh fa-spin fa-fw"></i></span>');
        myLi.addClass('loaded expand');
        $.get("index.php", {
            task: "legalDocuments",
            f: "rootScan",
            ajax: 1,
            dir: dir
        }, function (data) {
            myLi.children("a").children(".ld_icon").html('<i class="fa fa-folder-open-o" aria-hidden="true"></i>');
            myLi.children(".child_list").html(data);
        });
    } else if (myLi.hasClass('expand')) {
        myLi.removeClass('expand');
        myLi.children(".child_list").hide();
        myLi.children("a").children(".ld_icon").html('<i class="fa fa-folder-o" aria-hidden="true"></i>');
        
    } else if (!myLi.hasClass('expand')) {
        myLi.addClass('expand');
        myLi.children(".child_list").show();
        myLi.children("a").children(".ld_icon").html('<i class="fa fa-folder-open-o" aria-hidden="true"></i>');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
    return false;
})
