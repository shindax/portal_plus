        $(function(){
            $("#galleryStart").click(function() {
                    $("#photo_1").trigger('click');
            });
            
            $(".imga").adipoli({
                    'startEffect' : 'normal',
                    'hoverEffect' : 'popout'
            });

            $('.auto-submit-star').rating({
                callback: function(value, link){
                    var member = $("#member_id").val();
                    var photo_id = $("#photo_id").val();
                    var url = "/photoClub/setRating/" + member + "/" + photo_id + "/" + value;
                    $.get(url);
                    $("#starRatingDiv").html("<p class=\"n-qst-date\"> Спасибо!</p>");
                 }
                });

          $(".fancybox-thumb").fancybox({
		prevEffect	: 'fade',
		nextEffect	: 'fade',
                                        afterLoad   : function() {
                               //                 var orig = this.href.replace('\/medium\/', '\/original\/');
                                  //              this.title = '<a target="_blank" href="' + orig +'">Загрузить оригинал</a>'
                                        },
		helpers	: {
			title	: {
				type: 'inside'
			},
			thumbs	: {
				width	: 120,
				height	: 120
			},
                                                            overlay : {
                                                                    css : {
                                                                        'background' : 'rgba(40, 42, 45, 0.95)'
                                                                    }
                                                    }
		}
	});
        });

        $('.carousel').carousel({
                    interval: 2000
            });

        function validateCommonPhoto() {
            var filename = $("#photoFile").val();
            if(filename == "")  {
                alert("Файл не выбран");
                return false;
            }
            var ext = filename.split('.').pop().toLowerCase();
            if(ext != "jpeg" && ext != "jpg" && ext != "png") {
                alert("Допустимы только файлы изображений в формате jpeg и png");
                return false;
            }
            return true;
        }

    function del(url) {
                       if(window.confirm("Вы уверены?")) {
                        document.location.href = url;
                    }
    }

      function setComment(id) {
           var str = "#comment_" + id;
           var value = $(str).prop("checked");
           $.get("/admin//index.php?section=photoclub&f=setComment", {id : id, value : value, ajax : 1});
        }




