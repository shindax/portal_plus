$(document).ready(function(){
    //$('#birth_date').inputmask({alias:'date'});  //static mask
    
    /*
    var requiredInput = [
        'employee_name',
        'birth_date',
        'workname',
        'time',
        'sposob'
        'address',
        'pedagog',
        'participant'
    ];
    */
    
    var error;
    
    $('#rn-star-form-submit').click(function(){
        
        $.ajax({
            type: "POST",
            url: "/infocenter/saveAnketa",
            data: $("#rn-star-form").serialize(), // serializes the form's elements.
            success: function(data)
            {
                $('.form-result').removeClass('error').removeClass('success');
                
                $('.form-result').addClass(data.status);
                
                $('.form-result').html(data.message);
                
                if(data.status == 'success')
                {
                    $('#rn-star-form')[0].reset();
                }
                //console.log(data); // show response from the php script.
            },
            dataType: "JSON"
        });
        
        /*error = false;
        
        if($('input[name=nomination]:checked').length)
        {
            
        }
        else
        {
            error = true;
        }
        */
        
    });
    
});