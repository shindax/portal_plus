function go(href) {
    document.location.href = href;
}

function slide(obj)
{
    $(".gbcomm").slideUp("fast");
    $(obj).slideDown("normal");
}


var d = document;
    var safari = (navigator.userAgent.toLowerCase().indexOf('safari') != -1) ? true : false;
    var gebtn = function (parEl, child) { return parEl.getElementsByTagName(child); };
    onload = function () {

        var body = gebtn(d, 'body')[0];
        body.className = body.className && body.className != '' ? body.className + ' has-js' : 'has-js';

        if (!d.getElementById || !d.createTextNode) return;
        var ls = gebtn(d, 'label');
        for (var i = 0; i < ls.length; i++) {
            var l = ls[i];
            if (l.className.indexOf('label_') == -1) continue;
            var inp = gebtn(l, 'input')[0];
            if (l.className == 'label_check c_off') {
                l.className = (safari && inp.checked == true || inp.checked) ? 'label_check c_on' : 'label_check c_off';
                l.onclick = check_it;
            };
            if (l.className == 'label_radio r_off') {
                l.className = (safari && inp.checked == true || inp.checked) ? 'label_radio r_on' : 'label_radio r_off';
                l.onclick = turn_radio;
            };
        };
    };

    var check_it = function () {
        var inp = gebtn(this, 'input')[0];
        if (this.className == 'label_check c_off' || (!safari && inp.checked)) {
            this.className = 'label_check c_on';
            inp.value = 1;
            if (safari) inp.click();
        } else {
            this.className = 'label_check c_off';
            inp.value = 0;
            if (safari) inp.click();
        };
    };
    var turn_radio = function () {
        var inp = gebtn(this, 'input')[0];
        if (this.className == 'label_radio r_off' || inp.checked) {
            var ls = gebtn(this.parentNode, 'label');
            for (var i = 0; i < ls.length; i++) {
                var l = ls[i];
                if (l.className.indexOf('label_radio') == -1) continue;
                l.className = 'label_radio r_off';
            };
            this.className = 'label_radio r_on';
            if (safari) inp.click();
        } else {
            this.className = 'label_radio r_off';
            if (safari) inp.click();
        };
    };

$(document).ready(function() {
        jQuery.support.cors = true;

        // $.get("/index.php", { task: 'incidents', f: 'viewLink', ajax: 1 }, function (data) { $("div#menu ul li#serenalink").html(data); });

        $("#employee").autocomplete("/?task=autocomplete&f=findEmployee&ajax=1", {
                delay:200,
                minChars:4,
                autoFill:false,
                selectFirst: false,
                cacheLength: 0,
                max: 100
        });

        $("#department").autocomplete("/?task=autocomplete&f=findDepartment&ajax=1", {
                delay:200,
                minChars:4,
                autoFill:false,
                selectFirst: false,
                cacheLength: 0,
                max: 100
        });

        $("#employee").result(function(){
            $("employee").flushCache();
        });

        $("#employee").keyup(function(event){
        if(event.keyCode == 13){
            $("#employee_search").submit();
        }
        });

        $("a.fancy").fancybox({
		'opacity':false,
		'transitionIn':'elastic',
		'transitionOut':'fade'
	});

        $("a[href$=xls]").addClass("ico-l toxls gt");
        $("a[href$=XLS]").addClass("ico-l toxls gt");
        $(".content-wrp a[href$=xlsx]").addClass("ico-l toxls gt");
        $("a[href$=doc]").addClass("ico-l todoc gt");
        $("a[href$=docx]").addClass("ico-l todoc gt");
        $("a[href$=pdf]").addClass("ico-l topdf gt");
        $("a[href$=ppt]").addClass("ico-l toppt gt");
        $("a[href$=pptx]").addClass("ico-l toppt gt");
        $(".article a[href$=ppsx]").addClass("ico-l toppt gt");

        $("#employee").keyup(function(event){
          if(event.keyCode == 13){
              $("form#employee_search").submit();
          }
        });

    });

