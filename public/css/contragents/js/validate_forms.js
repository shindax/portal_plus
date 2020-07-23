jQuery(document).ready(function(){	
	$('#index_modal').submit(function()
   {
        if($('input[name="fio_user"]').val() == '')
        {
			$('input[name="fio_user"]').addClass('error_validate');
			$('input[name="fio_user"]').parent().find('.error_message').removeClass('hidden_error');
        }
        else
        {
			$('input[name="fio_user"]').removeClass('error_validate');
			$('input[name="fio_user"]').parent().find('.error_message').addClass('hidden_error');
        }
       if($('#message_user').val() == '')
       {
		   $('#message_user').addClass('error_validate');
		   $('#message_user').parent().find('.error_message').removeClass('hidden_error');
       }
       else
       {
		    $('#message_user').removeClass('error_validate');
			$('#message_user').parent().find('.error_message').addClass('hidden_error');
       }

       var reg= new RegExp("[0-9a-z_]+@[0-9a-z_^.]+\\.[a-z]{2,3}", 'i');
       if(!reg.test($('input[name="email_user"]').val()))
       {
		   $('input[name="email_user"]').addClass('error_validate');
		   $('input[name="email_user"]').parent().find('.error_message').removeClass('hidden_error');
       }
       else
       {
		   $('input[name="email_user"]').removeClass('error_validate');
		   $('input[name="email_user"]').parent().find('.error_message').addClass('hidden_error');

       }
       if($('#message_user').val() != '' && reg.test($('input[name="email_user"]').val()) && $('input[name="fio_user"]').val() != '')
       {
           return true;
       }

       return false;
   
   });     
   
});