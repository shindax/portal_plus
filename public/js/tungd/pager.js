
    function pager(pages, current, url)
    {
        var html = "";
        pages = parseInt(pages);
        current = parseInt(current);

        if(pages < 1) return false;

        var arr = [];

        var prev = current - 1;
        var next = current + 1;

        if(current > 1) html = html + '<li class="pn-l pn-l-lr" href="'+url+'&page='+prev+'">&larr;</li>';
        else html = html + "<li class='pn-l pn-l-lr'>&larr;</li>";

        /* Рисуем первые три страницы */
        for(var i = 1; i <= 2; i++)
        {
            if(current != i) html = html + ' <li class="pn-l" href="'+url+'&page='+i+'">'+i+'</li> ';
            else html = html +  '<li class="pn-l pn-l-a" href="javascript:void();">'+i+'</li>';
        }

        /* рисуем страницы в области текущей +- 2  */
        var left = current - 1;
        var right = current + 1;
        var noleftdots = false;
        var norightdots = false;


        if(left < 3) left = 3;
        if(right > pages - 2) right = pages - 2;

        if(left < 4) noleftdots = true;
        if(right > pages - 3) norightdots = true;

        if(!noleftdots) html = html + " ... ";

        if(pages > left)
        {
            for(var i = left; i <= right; i++)
            {
                if(current != i) html = html + ' <li class="pn-l" href="'+url+'&page='+i+'">'+i+'</li> ';
                else html = html +  '<li class="pn-l pn-l-a" href="javascript:void();">'+i+'</li>';
            }
            if(!norightdots) html = html + " ... ";
        }

        if(pages > 2) {
            var start = pages - 1;
            if(start < 3) start = 3;
            /* рисуем последние три страницы */
            for(var i = start; i <= pages; i++)
            {
                if(current != i) html = html + ' <li class="pn-l" href="'+url+'&page='+i+'">'+i+'</li> ';
                else html = html +  '<li class="pn-l pn-l-a" href="javascript:void();">'+i+'</li>';
            }
        }

        if(current < pages) html = html + '<li class="pn-l pn-l-lr" href="'+url+'&page='+next+'">&rarr;</li>';
        else html = html + '<span class="pn-l pn-l-lr">&rarr;</span>';
        $(".pager").html(html);
    }



