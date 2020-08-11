// Actions after full page loading
$( function()
{
	let but = $('.but3')
    $( but ).unbind('click').bind('click', but_click )

function but_click()
{
	let comment = $('#addComment').val()
	let employee_id = $( this ).data('employee-id')
	let employee_name = $( this ).data('employee-name')
	let target_id = $( this ).data('target-id')
	let target_type = $( this ).data('target-type')
	let route = $( this ).data('path')
	$.ajax({
        type: "POST",
        url: route,
        data: {
        	comment : comment,
        	target_id: target_id,
        	target_type : target_type,
        	employee_id : employee_id,
        	employee_name: employee_name
        },
        success: function(response) {


            $('#addComment').val("")
        	$('#retroaction p').addClass('hidden')
        	let id = '#comment_is_empty'
            if( response )
            		id = '#comment_ok'
            $( id ).removeClass('hidden')
        }
    });
}


});