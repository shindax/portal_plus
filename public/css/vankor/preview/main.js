$(document).ready(function() {

	$(".menu li").hover(function() {
		$(this).find(".menu-second").stop().slideDown();
	}, function() {
		$(this).find(".menu-second").stop().slideUp();
	});

	$(".nav ul ul").mCustomScrollbar({
		scrollButtons:{ enable: true }
	});

	$(".select").chosen({disable_search_threshold: 20});

	$(".chosen-drop").mCustomScrollbar({
		scrollButtons:{ enable: true }
	});

	$(".black-scroll").mCustomScrollbar({
		scrollButtons:{ enable: true }
	});

	$(".toggle-title").click(function() {
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

    $(".btn_open").click(function() {
        $(".toggle").addClass("active");
        $(".toggle-content").stop().slideDown();
        return false;
    });

    $(".btn_close").click(function() {
        $(".toggle").removeClass("active");
        $(".toggle-content").stop().slideUp();
        return false;
    });

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
        duration: 600
      },
      prev    : ".comments-right .btn_next",
      next    : ".comments-right .btn_prev"
    });

    $(".slider-content").carouFredSel({
        scroll      : {
            fx          : "slide"
        },
        items       : {
            visible     : 1,
            width       : 922,
            height      : 320
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
              kol = $(this.element).parents(".archive-item, .archive").find(".archive-image").size();


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

    $(".archive-list_photo .archive-item, .archive_photo").click(function() {

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

});
