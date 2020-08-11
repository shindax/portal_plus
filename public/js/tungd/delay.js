$(function(){
    $(".button").button();

    var dtobj = new Date();
    dtobj.setDate(dtobj.getDate() - 2);
    $("#date2").datepicker();                
    $("#date2").datepicker( "option", $.datepicker.regional[ "ru" ] );
    $("#date2").datepicker("option", "dateFormat", "yy-mm-dd");
    $("#date2").datepicker("setDate", dtobj);

    dtobj.setDate(dtobj.getDate() - 3);
    $("#date1").datepicker();                
    $("#date1").datepicker( "option", $.datepicker.regional[ "ru" ] );
    $("#date1").datepicker("option", "dateFormat", "yy-mm-dd");
    $("#date1").datepicker("setDate", dtobj);
    
    function subFunction(id) {
        var select = 'li#'+id+' input';
        var ckd = $(select).prop('checked');
        
        // Выбрать всё что внутри 
        $(select).prop({checked: ckd});
        
        $('input#department').val('');
    }
    /*
    function clickCheckbox(object) {
        $('input#'+object['id']).click();
    }
  */
    //window.clickCheckbox = clickCheckbox;
    window.subFunction = subFunction;
});



