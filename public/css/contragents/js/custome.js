jQuery(document).ready(function(){	
	
    
	/*main*/
	
	$('body a.delete_li_text').on('click',function(){
		if(confirm('Вы уверены что хотите удалить запись?'))
		{

		}
		else
		{
			return false;
		}

	});
    
    $('.show-tooltip').tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });

	$('#index_modal').submit(function(event){
		if($('#fio_user').val() == '')
		{
			$('#fio_user').focus();
		}
		else if($('#email_user').val() == '')
		{
			$('#email_user').focus();
		}
		else if($('#message_user').val() == '')
		{
			$('#message_user').focus();
		}
		else
		{
			$.get("index.php", 
				{
					section : "frontend", 
					f : "sendQuestions", 
					ajax: "1", 
					message: $('#message_user').val(),
					email: $('#email_user').val(),
					fio: $('#fio_user').val()
				},
				function(data){
					if(data.result)
					{
						alert(data.message);
						$('#message_user').val('');
						$('#email_user').val('');
						$('#fio_user').val('');
						$.fn.closeModal();
					}
					else
					{
						alert(data.message);
					}
				},
				'JSON'
			);
		}
		event.preventDefault();
		return false;
	});

	
	$('.link_send_zayavka_block').hover(function(){
		$(this).find('.ruchka').stop().animate({'top':'25'}, 300);
	},function(){
		$(this).find('.ruchka').stop().animate({'top':'40'}, 300);
	});
	
	$('.zayavka_left').hover(function(){
		$(this).find('.ruchka').stop().animate({'top':'40'}, 300);
	},function(){
		$(this).find('.ruchka').stop().animate({'top':'60'}, 300);
	});
	
	$('.link_send_zayavka').click(function(){
		
	});
	
	/*$('ul.left_menu li').click(function(){
		
		if($('ul').is($(this).find('ul')))
		{
			$(this).find('ul').slideToggle('fast');
			$(this).children('a').toggleClass('select_item');
			return false;
		}
		else
		{
		return true;
		}		
	});*/
	$('ul.left_menu li').hover(function(){
		if($('ul').is($(this).find('ul')))
		{
			$(this).find('ul').slideDown('fast');
			if($(this).children('a').attr('class') != 'select_item')
			{
				$(this).children('a').addClass('select_item');
			}		
		}
	},function(){
	
	});
	
	$('ul.left_menu li ul').hover(function(){
		
	},function(){
		$(this).slideUp('fast');
		$(this).parent().children('a').removeClass('select_item');
	});

	if($('.container').height() < $('.left-sidebar').height())
	{
		$('.middle').css({'padding-bottom':'250px'});
	}
	
	$('.list_library li span, div.hide_list').click(function(){	

		//console.log('click func',this);

		if($(this).parent().attr('class') =='active_item_library')
		{
			$(this).parent().removeClass('active_item_library');
			$(this).parent().find('.list_library_point').css({'background-position':'0px 0px'});
			$(this).parent().find('ul').slideUp();
			if($('ul').is($(this).parent().find('ul')))
			{
				$(this).parent().find('.arrow_down').css({'display':'none'});
			}
			$(this).parent().find('.list_library_point').css({'background-position':'0px 0px'});
			if($('ul').is($(this).parent().find('ul')))
			{
				$(this).parent().find('.arrow_down').css({'display':'none'});
				
			}
		}
		else
		{
			$('.list_library li span').each(function(){
				$(this).parent().removeClass('active_item_library');
				$(this).parent().find('.list_library_point').css({'background-position':'0px 0px'});
				$(this).parent().find('ul').slideUp();
				if($('ul').is($(this).parent().find('ul')))
				{
					$(this).parent().find('.arrow_down').css({'display':'none'});
				}
			});
			$(this).parent().addClass('active_item_library');
			$(this).parent().find('.list_library_point').css({'background-position':'-24px 0px'});
			if($('ul').is($(this).parent().find('ul')))
			{
				$(this).parent().find('.arrow_down').css({'display':'block'});
			}
			if($(this).parent().find('ul').css('display') == 'none')
			{
				$(this).parent().find('ul').slideDown();
			}
		}
	});
	
	
	$('.redactor_content .list_library li ul li').hover(function(e){
		$('.redactor_content .list_library li ul li').each(function(){
			$(this).find('.edit_li_hover_panel').remove();
		});
		var panel_editor = $('<div class="edit_li_hover_panel"><a href="501_add.html" class="edit_li_text colorbox" ></a><a href="#" class="delete_li_text"></a></div>');
		//$('a.edit_li_text').colorbox({href:"501_add.html"});
		$(this).append(panel_editor);
		$('.edit_li_hover_panel').css({'left':0 });
		$('.delete_li_text').click(function(){
		$(this).parent().parent().remove();
			return false;
		});
		$('.edit_li_text').click(function(){
			return false;
		});
		$('.edit_li_hover_panel').hover(function(){
		
		},function(){
			$('.redactor_content .list_library li ul li').each(function(){
				$(this).find('.edit_li_hover_panel').remove();
			});
		});
	},function(){
		//$(this).find('.edit_li_hover_panel').remove();
	});
	
	
	
	$(function() {
		if($('input').is($( ".datepicker" )))
		{
			$( ".datepicker" ).datepicker({
			  showOn: "button",
			  buttonImage: "images/calendar_icon.png",
			  buttonImageOnly: false,
			  dateFormat: "dd.mm.yy"
			});
		 }
	});
	
	$.fn.extend({
		updateSelectForTheme: function() {
			if($('select').is('.select_list_custome'))
			{
				$(".select_list_custome").each(function(){
					var w = parseInt($(this).width()),
					scrollPanel = $(this).find(".cusel-scroll-pane");
					if(w>=scrollPanel.width())
					{
						$(this).find(".jScrollPaneContainer").width(w);
						scrollPanel.width(w);
					}
					
				});
				var select_list_custome = {
					changedEl: ".select_list_custome",
					visRows: 3,
					scrollArrows: false
				}
				cuSel(select_list_custome);
				
				
				$(".select_list_custome").each(function(){

					if($(this).find('.cuselText').height() > 20)
					{
						$(this).find('.cuselText').css({'line-height':'22px'});
					}
					else
					{
						$(this).find('.cuselText').css({'line-height':'46px'});
					}
				});
			}
		}
	});

	$.fn.jsPlaceHolder = function(){

		$('.search_input_word.search_in_library_text').each(function(){			
			$(this).bind({
				blur: function(){
					if($(this).val() == '')
					{
						$(this).val($(this).attr('title'));
					}
					//console.log('blur: '+$(this).attr('title'));
				},
				focus: function(){
					if($(this).val() == $(this).attr('title'))
					{
						$(this).val('');
					}
				}
			});

		});
	};
	//$.fn.jsPlaceHolder();

	$.fn.customizeSelectInSearchForm = function(){
		$(this).each(function(){ 
			
			//console.log($(this).find('option'));
			var htmlToReplace = '';
			htmlToReplace = "<div class='psevdo_select_custome_mini' id=''> \
				<input type='hidden' class='main-select-stored-value' name='" + $(this).attr('name') + "' value='" + $(this).find('option:selected').val() + "'>    \
				<div class='title_psevdo_select'> \
					<div class='title_psevdo_select_value'>" + $(this).find('option:selected').html() + "</div><i class='psevdo_select_arrow'></i> \
				</div>\
				<div class='psevdo_select_options'> \
					<ul>";

				$(this).find('option').each(function(){
					if($(this).html() != '' && $(this).html() != ' ')
					{
						htmlToReplace = htmlToReplace + "<li>"+
							$(this).html()
							+ "<input type='hidden' value='"+ $(this).val() +"'>"

						+"</li>";
					}
				});

			htmlToReplace = htmlToReplace +
					"</ul> \
				</div> \
			</div>";
			$(this).wrap('<div id="select_'+$(this).attr('name')+'"></div>');
			$('#select_'+$(this).attr('name')).html(htmlToReplace);

		});
	};

	$.fn.openModal = function()
	{
        $('.md-overlay').css({'display':'block'});
        $('.modal').css({'display':'block'});
        $('#enter_modal').css({'display':'block'});
        $('#add_company_portfel_modal').css({'display':'none'});
        var w = $(window);
        $(".modal").css("top",(w.height()-$(".modal").height())/2+w.scrollTop() + "px");
        $(".modal").css("left",(w.width()-$(".modal").width())/2+w.scrollLeft() + "px");
        return false;
    };

    $.fn.closeModal = function(){
    	$('.md-overlay').css({'display':'none'});
        $('.modal').css({'display':'none'});
        $('#modal').removeClass('modal-in-library');
        
        if($('#library-media-player').length)
        {
            uppodSend('library-media-player','stop');
        }
        
        return false;
    };


	$('.search_in_library select').customizeSelectInSearchForm();
	

	$('body .cuselItem').on('mouseup',function(){
		$.fn.updateSelectForTheme();
	});

	$.fn.updateSelectForTheme();
	
	if($('a').is($('a.colorbox')))
	{
		$('a.colorbox').colorbox();
		$('a.colorbox').append('<div class="zoom_icon"></div>');
	}
	
	
	$('.header_menu_redactor ul li ul').each(function(){
		$(this).width($(this).parent().width()+20);
	});
	
	/*for event calendar*/
	
	$('.grid_calendar .time_day_calendar').height($('.grid_calendar .time_day_calendar').children().length * 50);
	$('.grid_calendar .vertical_calendar_day').height($('.grid_calendar .time_day_calendar').height());
	


	$('.modal_open').click($.fn.openModal);

    $('.md-overlay').click($.fn.closeModal);

    $('.close_modal a').click($.fn.closeModal);
	
	/*psevdo select*/
	$('body .psevdo_select_custome_mini .title_psevdo_select').on('click',function(){
		if($(this).parent().find('.psevdo_select_options').css('display') != 'block')
		{
			$(this).parent().addClass('psevdo_select_custome_mini_active');
			$(this).parent().find('.psevdo_select_options').css({'display':'block'});
			$(this).parent().find('.psevdo_select_arrow').css({'background-position':'-24px -24px'});
		}
		else
		{		
			$(this).parent().removeClass('psevdo_select_custome_mini_active');
			$(this).parent().find('.psevdo_select_options').css({'display':'none'});
			$(this).parent().find('.psevdo_select_arrow').css({'background-position':'0px -24px'});			
		}
	});
	
	$('body .psevdo_select_options li').on('click',function(){		
		// допиливаем кастомный селект.
	//	console.log($(this).find('input').val());

	//	console.log($(this).parent().parent().parent().find('input.main-select-stored-value'));
		$(this).parent().parent().parent().find('input.main-select-stored-value').val($(this).find('input').val());

		$('.psevdo_select_custome_mini').removeClass('psevdo_select_custome_mini_active');
		$(this).parent().parent().css({'display':'none'});
		$('.psevdo_select_custome_mini').find('.psevdo_select_arrow').css({'background-position':'0px -24px'});
		//$('.psevdo_select_custome_mini').find('.title_psevdo_select_value').empty().text($(this).text());	
		$(this).parent().parent().parent().find('.title_psevdo_select_value').empty().text($(this).text());		
	});
	
	/*checked custome checkbox*/
	$('input[type=checkbox].css-checkbox').click(function(){
		
		if($(this).is(':checked'))
		{
			$('.css-label[for="'+$(this).attr('id')+'"]').removeClass('css-checkbox_checked');

		//	$(this).parent().find('.css-label').removeClass('css-checkbox_checked');
			$(this).prop('checked','');
		}
		else
		{
			$('.css-label[for="'+$(this).attr('id')+'"]').addClass('css-checkbox_checked');
		//	$(this).parent().find('.css-label').addClass('css-checkbox_checked');
			$(this).prop({'checked':'checked'});
		}
	});

	$('.css-label').click(function(){
		if($(this).attr('for').length>0)
		{
			if($('#'+$(this).attr('for')).is(':checked'))
			{
				$(this).removeClass('css-checkbox_checked');
				$('#'+$(this).attr('for')).prop({'checked':''});
			}
			else
			{
				$(this).addClass('css-checkbox_checked');
				$('#'+$(this).attr('for')).prop({'checked':'checked'});
			}
		}
		else
		{
			if($(this).parent().find('input[type=checkbox].css-checkbox').is(':checked'))
			{
				$(this).removeClass('css-checkbox_checked');
				$(this).parent().find('input[type=checkbox].css-checkbox').prop({'checked':''});
			}
			else
			{
				$(this).addClass('css-checkbox_checked');
				$(this).parent().find('input[type=checkbox].css-checkbox').prop({'checked':'checked'});
			}
		}
	});
	
	$('input[type=checkbox].css-checkbox').each(function(){
		if($(this).is(':checked'))
		{
			$('.css-label[for="' + $(this).attr('id')+'"]').addClass('css-checkbox_checked');
			//$(this).parent().find('.css-label').addClass('css-checkbox_checked');
		}
	});
	
	$('table.sotrudnik_redactor tr:nth-child(3n) td').css({'border-bottom': '1px solid #000'});
	$('table.sotrudnik_redactor tr:first-child td').css({'border-bottom': '1px solid #000'});

	$('.table_curses table.presentation_table tr td:nth-child(2)').css({'width': '70%'});
	$('.table_curses table.presentation_table tr:last-child td').css({'border-bottom': '2px solid #000;'});
	
	
    $('.curator-items-cell-show-emp').click(function(){
        console.log(this);
        $(this).parent().find('.curator-items-table').slideToggle();
        
    });
    
    
});