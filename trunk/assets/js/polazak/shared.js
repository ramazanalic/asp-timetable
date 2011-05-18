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

    
    
    
    /* Kreiraj Novu Stanicu u bazi preko ajaxa i repopulate autokomplete dataset */
    
    $('.nova_stanica').live('click', function(){
        $.ajax({
            url: base_url+'stanica/core/ajax_add/',
            type: 'POST',
            success: function(data){
                $.modal(data.html);
            },
            dataType: 'json'
        });
    })

    $('#addstanica').live('submit',function(){
        $.ajax({
            url: base_url+'stanica/core/db_add/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){                
                if(data.success == 'success'){
                    $('#addstanica').fadeOut('fast',function(){$('#addstanica').remove()});
                    repopulate_ac();
                }else{
                    $('#infomessage').html(data.message).fadeIn('normal');
                }
            },
            dataType: 'json'
        });
    });

    function repopulate_ac(){
        
        $.modal.close();

        $('#ajax_loader').show('slow');

        $('html, body').animate({
            scrollTop: $("#ajax_loader").offset().top
        }, 200);
        
        $.ajax({
            
            url: base_url+'stanica/core/ajax_ac_complete/',
            
            type: 'POST',
            
            success: function(data){
                
                $("input.ac_stanica").autocomplete({ source: data.html }); 
                
                $('#ajax_loader').hide('slow');
                
            },
            
            dataType: 'json'
            
        });           
    }

});