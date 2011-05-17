$(function(){     

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

});