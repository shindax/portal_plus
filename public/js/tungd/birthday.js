function birthday(i) {
            $("#bday_link_1").removeClass('n-main-bthd-link').removeClass('n-main-bth-linkm').addClass('n-main-bth-linkm');
            $("#bday_link_2").removeClass('n-main-bthd-link').removeClass('n-main-bth-linkm').addClass('n-main-bth-linkm');
            $("#bday_link_3").removeClass('n-main-bthd-link').removeClass('n-main-bth-linkm').addClass('n-main-bth-linkm');
            $("#bday_link_" + i).removeClass('n-maibth-linkm').addClass('n-main-bthd-link');

            $("#birthday_1").css('display', 'none');
            $("#birthday_2").css('display', 'none');
            $("#birthday_3").css('display', 'none');
            $("#birthday_"+i).css('display', 'block');
    }