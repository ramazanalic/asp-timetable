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



    // get the current date

    var date = new Date();
    var m = date.getMonth(),
    d = date.getDate() + 1,
    y = date.getFullYear();

    // Datepicker
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

    $('#prvipolazak').click(function(){
        $('#prvipolazak').datepicker("show");  
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

    $('#zadnjipolazak').click(function(){
        $('#zadnjipolazak').datepicker("show");  
    }); 


    delete_answer = false;
    var rb_stanice = 6;
    //BRISI STANICU IZ DB

    $('.delete-stop').live('click',function(){
        if(delete_answer){
            if (confirm('Da li ûelite izbrisati stanicu iz baze?')) {
                var remove = this;
                var id=remove.id.substr(7,remove.id.length);
                $.ajax({
                    type: 'POST',
                    url: base_url+'anketa/uredi_anketu/deleteanswer/'+id,
                    dataType: 'json',
                    success: function(data){
                        if(data.success=='failed'){
                            alert('Ne≈°to nije uredi prilikom brisanja.')
                        }else{
                            jQuery(remove).parent().parent().parent().parent().fadeOut('slow',function() {
                                $(this).empty();
                            });
                        }
                    },
                    error:function(data){alert("Error: " + data);}
                });
            }
        }else{
            jQuery(this).parent().parent().parent().fadeOut('slow',function() {
                jQuery(this).remove();
            });
        }
    })

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