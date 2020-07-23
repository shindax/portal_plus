/**
 * Блок отображения/скрытия сорвисного сообщения на главной странице
 * vvdanilevskiy, 14.11.2018
 */
$(document).ready(function() {
    /**
     * @type {boolean} - true/false - Включить/выключить уведомление о Технических работах
     */
    var service_mode = false;

    if (service_mode === true) $('.portalWorkNotice').slideDown();
    $('.portalWorkNotice__close').on('click', function () {
        $('.portalWorkNotice').slideUp();
        return false;
    });
});