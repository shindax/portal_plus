function go(href) {
    document.location.href = href;
}


function birthday(date) 
{  
        var caller = $("#btn" + date);
        
        // Клик на сегодняшний день
        if(caller.hasClass('active')) {
            return;
        }
        
        $(".active").removeClass("active");
        caller.addClass("active");
            
            $.get("/index/birthday/" + date, function(data){                
                $("#birthdays").html(data);
                   $(".birthday-slider").carouFredSel({
                        circular: false,
                        infinite: false,
                        align: "left",
                        width: "100%",
                        items : {
                          visible: 5
                        },
                        prev    : {
                            button  : ".birthday-slider-nav .btn_prev",
                            key     : "left"
                        },
                        next    : {
                            button  : ".birthday-slider-nav .btn_next",
                            key     : "right"
                        },
                        pagination  : ".birthday-slider-nav .pagination"
                    });
            });
}

function setResult()
{
    var answer_id = $('input.poll-active-radio:radio:checked').val();
    if (answer_id == null)
        alert('Вы не выбрали ответ!');

    $.post("index.php", {
          task : "interviews",
          f : "setResult",
          ajax : 1,
          answer_id : answer_id
        }, function (data) {
            //$('div#interviewArea').html(data);
            $.get("index.php", {
                  task : "interviews",
                  f : "viewInterview",
                  ajax : 1
                }, 
                function(data)
                {
                    $('div.poll_start').replaceWith(data);
                    $('div.poll_start').parent().append('<p style="color:green; font-weight:bold;">Спасибо за участие в опросе!</p>');
                }
            )
        }
    )
}

// обновление статичных данных
function updateStaticData()
{
  $.getJSON("/?task=static_data&f=allData&ajax=1", {}, function(data) {
    for (var key in data) 
    {
      var suffix = '';
      if(key == 'speed_wind_vpu')
      {
        suffix = ' <span>м/с</span>';
      }

      if($('#static_data_'+key).length)
      {
        $('#static_data_'+key).html(data[key]+suffix);
      }
      if($('#static_data_'+key+'1').length)
      {
        $('#static_data_'+key+'1').html(data[key]+suffix);
      }
    }
    
  });
}
        
$(document).ready(function() {
        jQuery.support.cors = true;
        
/*        $.get("/index.php", {task: 'incidents', f : 'viewLink', ajax : 1}, function(data) {
            $("#serenalink").html(data);
            $("#serenalinkbottom").html(data);
        });*/
        
          var format_weather = function(weather) {
                if(weather.substr(0,1) !== "-" && weather.substr(0,1) !== "+" ) {        	
                    weather = "+" + weather;
                }
        	return "<img src=\"/images/weather1.png\" alt=\"\">" + weather + "&deg;";
        };
        
        /* $.getJSON("/?task=static_data&f=allData&ajax=1", {}, function(data) {
        	$("#krskWeather").html(format_weather(data.weather_current) + "<span>КРАСНОЯРСК</span>");
        	$("#vankorWeather").html(format_weather(data.weather_remote) + "<span>ВАНКОР</span>");
        	$("#currencyUSD").html(data.currency_usd);
        	$("#currencyEUR").html(data.currency_euro);
        });
        */

        /* Автообновление статичных данных на главной странице */
        // var staticDataTimerId = setInterval(updateStaticData, 5*60*1000);

        /* $.get("/index.php", {task: 'incidents', f : 'viewLink', ajax : 1}, function(data) { $("div#menu ul li#serenalink").html(data);});*/
        
        
        /* $("#employee").autocomplete("/?task=autocomplete&f=findEmployee&ajax=1", {
                delay:200,
                minChars:4,
                autoFill:false,
                selectFirst: false,
                cacheLength: 0,
                max: 100
        }); */

    $(".chosen-select").chosen();

	$(".menu li").hover(function() {
		$(this).find(".menu-second").stop().slideDown();
	}, function() {
		$(this).find(".menu-second").stop().slideUp();
	});

	$(".nav ul ul").mCustomScrollbar({
		scrollButtons:{ enable: true }
	});

	$(".select").chosen({disable_search_threshold: 5}); // 20

	$(".chosen-drop").mCustomScrollbar({
		scrollButtons:{ enable: true }
	});

	$(".black-scroll").mCustomScrollbar({
		scrollButtons:{ enable: true }
	});

	//$(".toggle-title").click(function() {
  $(".toggle-icon").click(function() {
		$(this).parent().toggleClass("active").children(".toggle-content").slideToggle();
	});

  $(".toggle_poll .toggle-title").click(function() {
    $(this).parent().toggleClass("active").children(".toggle-content").slideToggle();
  });

	var sameHeight = function(same) {
      same.height("auto");
      var $sameHeightDivs = same;
      var maxHeight = 0;
      $sameHeightDivs.each(function() {
            maxHeight = Math.max(maxHeight, $(this).outerHeight());
      });
      $sameHeightDivs.css({ height: (maxHeight) + 'px' });
  	};

    var sameSlice = function() {
      if($(".layout_main-wrap_fixed").size()) {

      } else {
        $(".articles").each(function() {
            var item = $(this).find(".articles-item"),
                kol = item.size();
            for(var i=0; i<kol; i=i+3) {
                sameHeight(item.slice(i,i+3));
            };
        });

        $(".articles-top").each(function() {
            var item = $(this).find(".articles-item"),
                kol = item.size();
            for(var i=0; i<kol; i=i+2) {
                sameHeight(item.slice(i,i+2));
            };
        });
      }
    };

  	$(window).load(function() {
            
  		sameHeight($(".archive-item, .worker-item, .birthday-list .birthday-item, .layout_contentHalfBlock_bordered"));
      sameSlice();
  	});

    $(window).resize(function() {
        sameHeight($(".archive-item, .worker-item, .birthday-list .birthday-item, .layout_contentHalfBlock_bordered"));
        sameSlice();
    });
    
  
  // Выравнивание лучших работников по высоте        
sameHeight($(".best-item, .desk-item"));
sameSlice();


  	$(".btn_open-all").click(function() {
  		if($(this).hasClass("active")) {
  			$(this).text("Раскрыть все");
        $(this).removeClass("active");
        $(".toggle").removeClass("active").children(".toggle-content").slideUp();
        
  		} else {
  			$(this).text("Закрыть все");
        $(this).addClass("active");
        $(".toggle").addClass("active").children(".toggle-content").slideDown();
  		};
  		return false;
  	});

    /* $(".btn_open").click(function() {
        $(".toggle").addClass("active");
        $(".toggle-content").stop().slideDown();
        return false;
    });

    $(".btn_close").click(function() {
        $(".toggle").removeClass("active");
        $(".toggle-content").stop().slideUp();
        return false;
    }); */

    $(".radio input").click(function() {
      if($("#r2").prop("checked")) {
        $(".form-row.hidden").slideDown();
      } else {
        $(".form-row.hidden").slideUp();
      }
    });
    
    $('.top-slider').carouFredSel({
      width: '100%',
      height: 24,
      direction: 'up',
      items: 1,      
      scroll: {
        pauseOnHover : true,
        duration: 600
      },
      prev    : ".layout_contentLeftBlock_top-slider .btn_next",
      next    : ".layout_contentLeftBlock_top-slider .btn_prev"
    });

  
    $('.comments-slider').carouFredSel({
      width: '100%',
      height: '100%',
      align: 'top',
      direction: 'up',
      items: "variable",
      
      scroll: {
        items: 1,
        pauseOnHover : true,
        duration: 600
      },
      auto: {
        play: false        
      },
      prev    : ".comments-right .btn_next",
      next    : ".comments-right .btn_prev"
    });

    
    $(".slider-content").carouFredSel({
        scroll      : {
            fx          : "slide",
            duration        : 600,
            pauseOnHover : true,
        },
        auto: {
          play: false        
        },
        items       : {
            visible     : 1,
            width       : 922,
            height      : 520
        },
        pagination: {
          container: '.slider .pagination'
        }
    });


    $(".birthday-slider").carouFredSel({
        circular: false,
        infinite: false,
        align: "left",
        width: "100%",
        scroll: {
          pauseOnHover : true,
        },
        items : {
          visible: 5
        },
        prev    : {
            button  : ".birthday-slider-nav .btn_prev",
            key     : "left"
        },
        next    : {
            button  : ".birthday-slider-nav .btn_next",
            key     : "right"
        },
        pagination  : ".birthday-slider-nav .pagination"
    });

    $(".fancy").fancybox({
      margin: 60,
      padding: 0,
      beforeLoad: function() {
            var el, id = $(this.element).data('title-id');

            if (id) {
                el = $('#' + id);
            
                if (el.length) {
                    this.title = el.html();
                }
            }
        }
    });

    $(".archive-image").fancybox({
      margin: 60,
      padding: 0,
      beforeLoad: function() {
          var el, id = $(this.element).data('title-id'),
              rel = $(this.element).attr('rel');
          var
              kol = $(this.element).parent().parent().find("[rel='"+rel+"']").size();
              //kol = $(this.element).parents(".archive-item, .archive").find(".archive-image").size();


          if (id) {
              el = $('#' + id);
          
              if (el.length) {
                  this.title = "<span class='fancy-title-index'><b>" + (this.index + 1) + "</b> / " + kol +"</span>" + el.html();
              }
          }
      }
    });

    $(".archive-image_video").fancybox({
      wrapCSS: 'video-fancy',
      margin: 60,
      padding: 0,
      openEffect  : 'none',
      closeEffect : 'none',
      helpers : {
        media : {}
      },
      beforeLoad: function() {
              var el, id = $(this.element).data('comment-id');

              if (id) {
                  el = $('#' + id);
              
                  if (el.length) {
                      this.title = el.html();
                  }
              }
          }
    });

    $(".archive-list_photo .archive-item .archive_photo_container, .archive_photo .archive_photo_container").click(function() {

      $.fancybox.open($(this).find(".archive-image")
        , {
          margin: 60,
          padding: 0,
          beforeLoad: function() {
              var el, id = $(this.element).data('title-id'),
                  kol = $(this.element).parents(".archive-item, .archive").find(".archive-image").size();

              if (id) {
                  el = $('#' + id);
              
                  if (el.length) {
                      this.title = "<span class='fancy-title-index'><b>" + (this.index + 1) + "</b> / " + kol +"</span>" + el.html();
                  }
              }
          }
        }); 
    });

    $(".archive-list_video .archive-item, .archive_video").click(function() {

      $.fancybox.open($(this).parent().find(".archive-image_video")
        , {
            wrapCSS: 'video-fancy',
            margin: 60,
            padding: 0,
            openEffect  : 'none',
            closeEffect : 'none',
            helpers : {
              media : {}
            },
            beforeLoad: function() {
                    var el, id = $(this.element).data('comment-id');

                    if (id) {
                        el = $('#' + id);
                    
                        if (el.length) {
                            this.title = el.html();
                        }
                    }
                }
        });
    });

        
        // $(".employee").autocomplete("/?task=autocomplete&f=findEmployee&ajax=1", {
        //         delay:200,
        //         minChars:4,
        //         autoFill:false,
        //         selectFirst: false,
        //         cacheLength: 0,
        //         max: 100
        // });
        //
        // $(".employee").result(function(){
        //     $(".employee").flushCache();
        // });
        //
        // $("#employee").keyup(function(event){
        //   if(event.keyCode == 13){
        //       $("form#employee_search").submit();
        //   }
        // });
        //
        // $("#searchField").keyup(function(event){
        //   if(event.keyCode == 13){
        //       $("form#employee_search_2").submit();
        //   }
        // });
        
      var weatherOpen = false;
      $('#weather-svodka-link').click(function(){
          if($('.weather-svodka-layer').length)
          {
            $('.weather-svodka-layer').slideToggle();
            $('.weather-svodka').slideToggle();
            weatherOpen = !weatherOpen;
          }

      });

      if($('.weather-svodka-layer').length)
      {
        $('body').on('click','.weather-svodka-layer',function(){
          //console.log(this,weatherOpen);
          if(weatherOpen)
          {
            $('.weather-svodka-layer').slideUp();
            $('.weather-svodka').slideUp();
            weatherOpen = false;
          }
        });

      }
    
});
