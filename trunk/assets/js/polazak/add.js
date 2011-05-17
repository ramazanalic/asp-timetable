$(function(){     

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
            if (confirm('Da li želite izbrisati stanicu iz baze?')) {
                var remove = this;
                var id=remove.id.substr(7,remove.id.length);
                $.ajax({
                    type: 'POST',
                    url: base_url+'anketa/uredi_anketu/deleteanswer/'+id,
                    dataType: 'json',
                    success: function(data){
                        if(data.success=='failed'){
                            alert('Nešto nije uredi prilikom brisanja.')
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


    $('#addpolazak').live('submit',function(){
        $.ajax({
            url: base_url+'polazak/core/db_add/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                $.modal.close();
                if(data.success == 'success'){
                    $('#infomessage').css('border-left','4px solid #7c9c59'); 
                    $('#infomessage').html('Dodali ste polazak.<a class="cmsbtn ml-6" href='+base_url+'polazak/core/add>Dodaj još</a>').fadeIn('normal');
                    $('#addpolazak').fadeOut('fast',function(){$('#addpolazak').remove()});
                }else{
                    $('#infomessage').html(data.message).fadeIn('normal');
                    $('html, body').animate({
                        scrollTop: $("#infomessage").offset().top
                    }, 400);
                }
            },
            dataType: 'json'
        });
    });


    /* Time Set Handlers */

    $('#vrijemepolaska_pocetna').change(function(){
        
        $("#vrijemedolaska-1").val($(this).val());
        
    })

    $('.vrijemedolaska').live('change', function(){
        
        var id = this.id.substring(15,this.id.length);
        
        console.log("#vrijemepolaska-"+id)
        
        $("#vrijemepolaska-"+id).val($(this).val());
        
    })
    
    $('.vrijemepolaska').live('change', function(){
        
        var id = this.id.substring(15,this.id.length);
        
        id = parseInt(id)+1;
        
        console.log("#vrijemedolaska-"+id)
        console.log("rb_stanice:"+rb_stanice)
        
        if(rb_stanice == id){
            
            $("#vrijemedolaska_zadnja").val($(this).val());    
            
        }else{
            
            $("#vrijemedolaska-"+id).val($(this).val());     
            
        }
        
    })

});