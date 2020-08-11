$(function(){
	$("input:checkbox").click(function() {
		var section_id = $(this).val();
		var user_id = $("#user_id").val();
		var value = $(this).prop('checked') ? 1 : 0;
		var cbx = $(this);

		$(this).prop('disabled', 'disabled');

		$.get('index.php', {section: 'user', f : 'setaccess', user_id : user_id, section_id : section_id, 'ajax' : 1, val : value}, function(data) {
			if(data != "1") {
				alert("Не удалось установить права. \n" + data);				
			}
			else {				
				cbx.removeProp('disabled');				
			}
		});
	});

});