jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};


/* ====================================================================

Скрипт для создания падающих снежинок на сайте исключительно средствами CSS.
Работа скрипта проверена в MSIE 6, Opera, Firefox, Google Chrome.
Copyright: 2010, 4X_Pro (http://xxxxpro.ru) для сайта MOGU.TV
Скрипт распространяется на условиях лицензии GNU GPL.

======================================================================

Настройки: */
/* Цвета снежинок */
var snow_color=new Array("#AABBEE","#DDEEFF","#CCDDFF","#F3F3FF","#E0F0FF");
/* Шрифты снежинок */
var snow_font=new Array("Times New Roman","Verdana","Georgia","Lucida Console");
/* Количество снежинок */
var snow_count=100;
/* Максимальняа скорость горизонтального ветра */
var snow_wind_dif=4;
/* Начальная скорость ветра */
var snow_wind=3;
/* ==================================================================== */

var snowitems = new Array();
var snowxpos = new Array();
var snowypos = new Array();
var snow_newwind = 0;
var snow_max_x = screen.availWidth;
var snow_max_y = document.documentElement ? document.documentElement.scrollHeight : document.body.scrollHeight; //screen.availHeight;
snow_max_y -= 50;

// Движение снежинок
function snow_move() {
  for (i=0; i<snowitems.length; i++) {
    // горизонтальное смещение снежинки
    snowxpos[i]=snowxpos[i]+snow_wind;
    if (snowxpos[i]>snow_max_x) { snowxpos[i]=0; }
    if (snowxpos[i]<0) snowxpos[i]=snow_max_x;
    snowitems[i].style.right=snowxpos[i]+'px';

   // вертикальное смещение снежинки
    snowitems[i].style.top=(snowypos[i])+'px';
    if (i % 3==0) snowypos[i]+=2;
    if (i % 3==1) snowypos[i]+=3;
    if (i % 3==2) snowypos[i]+=4;

    if (snowypos[i]>=snow_max_y) {
      snowxpos[i]=Math.floor(Math.random()*snow_max_x);
      snowypos[i]=0;
      var size=28+((i+1) %3)*Math.floor((Math.random()*6));
      snowitems[i].style.fontSize=size+'px';
      snowitems[i].style.color=snow_color[Math.floor(Math.random()*snow_color.length)];
      snowitems[i].style.fontFamily=snow_font[Math.floor(Math.random()*snow_font.length)];
    }
  }
}

// Плавное изменение направления ветра
function snow_wind_change() {
  // если достигли предыдущего намеченного значения ветра, то выбираем новое намеченное значение
  if (snow_wind==snow_newwind && Math.random()<0.5) snow_newwind= Math.round(Math.random()*snow_wind_dif*2-snow_wind_dif);
  if (snow_wind<snow_newwind) snow_wind++; // если текущее значение ветра меньше намеченного, увеличиваем ветер
  if (snow_wind>snow_newwind) snow_wind--; // если текущее меньше намеченного -- уменьшаем
}

$(function() {
for (i=0; i<snow_count; i++) {
    snowitems[i]=new Array();
    snowitems[i]=document.createElement('div');
    snowitems[i].innerHTML='*';
    snowitems[i].style.position='absolute';
    var size=28+((i+1) %3)*Math.floor((Math.random()*6));
    snowitems[i].style.fontSize=size+'px';
    snowitems[i].style.color=snow_color[Math.floor(Math.random()*snow_color.length)];
    snowitems[i].style.fontFamily=snow_font[Math.floor(Math.random()*snow_font.length)];
    snowxpos[i]=Math.floor(Math.random()*snow_max_x);
    snowypos[i]=Math.floor(Math.random()*snow_max_y);
    document.body.appendChild(snowitems[i]);
}

var c = jQuery.cookie('snow');
if (c == '0') {
} else {
	a = setInterval(snow_move,50);
	b = setInterval(snow_wind_change,5000);

}
});