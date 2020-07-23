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

    //$(".toggle-title").click(function() {
    $(".toggle-title-click").click(function() {
        $(this).parent().parent().toggleClass("active").children(".toggle-content").slideToggle();
    });
    
    function subFunction(id) {
        var select = '.li-toggle-id-'+id+' input';
        var ckd = $(select).prop('checked');

        console.log(select);
        
        // Выбрать всё что внутри 
        $(select).prop({checked: ckd});
        
        $('input#department').val('');
    }

    $("#department").autocomplete("/?task=autocomplete&f=findDepartment&ajax=1", {
            delay:200,
            minChars:4,
            autoFill:false,
            selectFirst: false,
            cacheLength: 0,
            max: 100
    });
    /*
    function clickCheckbox(object) {
        $('input#'+object['id']).click();
    }
  */
    //window.clickCheckbox = clickCheckbox;
    window.subFunction = subFunction;
});



