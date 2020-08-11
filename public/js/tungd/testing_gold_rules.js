/*
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$(function () {
    getTestingGoldRules();
});


/**
 * Запрашиваем html страницу c перечнем вопросов по тестированию на Золотые правила
 *
 * ТЮНГД доработка: Тестирование на золотые правила
 * 4IT SC0000571430, SC0000785012
 */
function getTestingGoldRules() {

    /*$.modal.defaults = {
        escapeClose: false,
        clickClose: false,
        showClose: false,

        fadeDuration: 100,
        fadeDelay: 1.0,
    };*/


    /**
     * Запрашиваем информацию проходил ли сегодня пользователь тестирование
     * @type {string}
     */
    var needToShowTest = '';
    for (var i = 0; i < 1; i++) { // цикл для тестов

        // ajax через $.ajax
        var needToShowTestPromise = $.ajax({
            url: '/?task=testingGoldRules&f=needToShowTest&ajax=1',
            success: function (response, textStatus, jqXHR) {
                needToShowTest = JSON.parse(response);
                if(needToShowTest.answer != false){
                    showTest();
                }
                console.log(textStatus, "Запросили needToShowTest", jqXHR);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus, "Не удалось запросить needToShowTest", errorThrown);
            }
        });

        // //// ajax через $.get
        // var needToShowTestPromise = $.get("/?task=testingGoldRules&f=needToShowTest&ajax=1", function (response) {
        //     needToShowTest = JSON.parse(response);
        //     console.log("Запросили needToShowTest");
        // });

    }

    /**
     * Если пользователь сегодня ещё не проходил тестирование, то
     * запрашиваем вопросы для показа в modal
     */
    var getQuestionsPagePromise = needToShowTestPromise.then(function () {

        /** Проверяем нужно ли показывать тест этому сотруднику */
        if (needToShowTest && needToShowTest.answer && needToShowTest.answer === true) {

            /** Запрашиваем html с вопросами */
            return $.ajax({
                url: '/?task=testingGoldRules&f=getQuestionsPage&ajax=1',
                success: function (response, textStatus, jqXHR) {
                    console.log(textStatus, "Запросили getQuestionsPage", jqXHR);
                    $(".modal_waiter").html(response);

                    // Активируем jquery.ui checkboxradio
                    //$('input.gold-rules__radio').checkboxradio();
                    return true;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, "Не удалось запросить getQuestionsPage", errorThrown);
                }
            });
        } else {
            console.log("Этому сотруднику не нужно показывать тест на Золотые правила труда: "+needToShowTest.result);
        }
    });



    var getQuestionsPagePromise = getQuestionsPagePromise.then(function () {

        $('.gold-rules__submit').on('click', function () {

            // ToDo Дописывать отсюда
           // console.log("Тут будет проверка теста."); /// !!!!!!!!!!!!!!!!!! /// !!!!!!!!!!!!!!!!!! /// !!!!!!!!!!!!!!!!!!

            let form = $('.gold-rules__form').serializeArray();
            let notices = $('.gold-rules__notify');
            notices.each(function (index, value) {
                $(value).hide();
            });

            // console.log('проверям и сохраняем ответ');
            var correct = "";
            var qqq = $.ajax({
                url: '/?task=testingGoldRules&f=checkAnswer&q='+form[0].name+'&a='+form[0].value+'&ajax=1',
                success: function (response, textStatus, jqXHR) {
                    console.log(textStatus, "Запросили checkAnswer", jqXHR);
                    //console.log(JSON.parse(jqXHR.responseText).count_right_answer);

                    //if (response == "1") { // если ответ верный - можно закрыть окно и отметить в куках что сегодня прошли тест
                    if (JSON.parse(jqXHR.responseText).result == "1") { // если ответ верный - можно закрыть окно и отметить в куках что сегодня прошли тест
                        // console.log('ответ верный');
                        $(notices[0]).show(); // ответ верный
                        $('.gold-rules__close').show(); // показываем кнопочку закрыть
                        var tomorrow = new Date();
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        var nextday = new Date((tomorrow.getMonth() + 1) + ',' + tomorrow.getDate() + ',' + tomorrow.getFullYear() + ',00:00:00');
                        document.cookie = "testingGoldRulesToday=1; expires=" + nextday.toUTCString();
                    } else {
                        // console.log('ответ не верный');
                        $(notices[1]).show(); // ответ не верный
                        if (JSON.parse(jqXHR.responseText).count_right_answer == 0) // если достаточно 0 правильных ответов:
                            $('.gold-rules__close').show(); // показываем кнопочку закрыть сразу
                    }
                    return true;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, "Не удалось запросить checkAnswer", errorThrown);
                }
            });

            return false;

            /**
             * Тут можно обработать форму, если потребуется сохранять ответы и как-то их анализировать
             * Данные будут отправлены на сервер для обработки
             */
            // $('.gold-rules__form').ajaxSubmit({
            //     url: '/?task=testingGoldRules&f=checkAnswers&ajax=1',
            //     type: 'post'
            // });

        });

    });

}