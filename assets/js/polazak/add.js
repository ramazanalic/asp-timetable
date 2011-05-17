$(function(){     

    delete_answer = false;
    var rb_stanice = 6;



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