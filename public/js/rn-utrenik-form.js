$(document).ready(function(){
   
    var error;
    var i = 1;
    var child_form;
    
    $('#child-form-add').click(function () {

        child_form =
            '<div class="child-form" style="margin-top: 20px;">' +
            '<div><span>ФИО ребёнка:</span> <input name="answer[child][' + i + '][name]" type="text" placeholder="ФИО ребёнка" required></div>' +
            '<div><span>Год рождения ребёнка:</span> <input name="answer[child][' + i + '][bday]" type="text" placeholder="Год рождения ребёнка" required></div>' +
            '<div><span>Возраст ребёнка:</span> <input name="answer[child][' + i + '][age]" type="text" placeholder="Возраст ребёнка" required></div>' +
            '</div>';

        $('#child-forms').append(child_form);
        $('#rn-utrenik-form-submit').show();

        i++;
        return false;

    });

    $('#rn-utrenik-form-submit').click(function(){
        
        $.ajax({
            type: "POST",
            url: "/infocenter/saveAnketaUtrenik",
            data: $("#rn-utrenik-form").serialize(), // serializes the form's elements.
            success: function(data)
            {
                $('.form-result').removeClass('error').removeClass('success');
                $('.form-result').addClass(data.status);
                $('.form-result').html(data.message);
                if(data.status == 'success')
                {
                    $('#rn-utrenik-form')[0].reset();
                }
                console.log(data); // show response from the php script.
            },
            dataType: "JSON"
        });
        
    });
    
});