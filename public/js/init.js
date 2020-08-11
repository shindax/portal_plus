function go(href) {
    document.location.href = href;
}


$(document).ready(function() {
        jQuery.support.cors = true;

        // $.get("/index.php", {task: 'incidents', f : 'viewLink', ajax : 1}, function(data) { $("div#menu ul li#serenalink").html(data);});



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




    });
