$(function(){     

    $('.stop-stanica-holder input').live('focus', function() {
        if($(this).val()=='Ostavite prazno da bi obrisali stanicu'){
            $(this).val('');
            $(this).removeClass('idle');
        }
    });
    $('.stop-stanica-holder input').live('blur', function() {
        if($(this).val()==''){
            $(this).addClass('idle');
            $(this).val('Ostavite prazno da bi obrisali stanicu');
        }
    });
    $( "#sortable" ).sortable({
        axis: 'y',
        containment: 'parent',
        handle: '.move',
        tolerance: 'pointer'
    }); 



    /* Get the current date */

    var date = new Date();
    var m = date.getMonth(),
    d = date.getDate() + 1,
    y = date.getFullYear();

    /* Init datepicker */


    $('#prvipolazak').datepicker({ 
        showOn: 'button',
        buttonImage: base_url+'assets/img/backgnds/calendar2.gif',
        buttonImageOnly: true,
        minDate: new Date(y, m, d),
        maxDate: new Date(y, m+12, d),
        dateFormat: 'dd.mm.yy',
        inline:true,
        numberOfMonths: 3

    });    

    $('#zadnjipolazak').datepicker({ 
        showOn: 'button',
        buttonImage: base_url+'assets/img/backgnds/calendar2.gif',
        buttonImageOnly: true,
        minDate: new Date(y, m, d),
        maxDate: new Date(y, m+12, d),
        dateFormat: 'dd.mm.yy',
        inline:true,
        numberOfMonths: 3

    });

    $('#prvipolazak').click(function(){
        $('#prvipolazak').datepicker("show");  
    });

    $('#zadnjipolazak').click(function(){
        $('#zadnjipolazak').datepicker("show");  
    }); 


    /* Briši stanicu iz DOM-a */

    $('.delete-stop').live('click',function(){ 
        jQuery(this).parent().parent().parent().fadeOut('slow',function() {
            jQuery(this).remove();
        });                                    
    })


    /* Kreiraj stop stanicu */

    $('.create-stop').live('click', function(){
        $.ajax({
            type: 'POST',
            url: base_url+'polazak/core/daj_stop_stanicu',
            data: ({ rb_stanice : rb_stanice }),
            dataType: 'json',
            success: function(data){$('#sortable').append(data.html); rb_stanice++; $.modal.close()},
            error:function(data){$.modal.close(); alert("Error: " + data);}
        });
    }) 


});