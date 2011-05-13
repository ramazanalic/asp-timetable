
$(document).ready(function(){

    $('#addstanica').live('submit',function(){
        $.ajax({
            url: base_url+'stanica/core/db_add/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                $.modal.close();
                if(data.success == 'success'){
                    $('#infomessage').css('border-left','4px solid #7c9c59'); 
                    $('#infomessage').html('Dodali ste stanicu.<a class="cmsbtn ml-6" href='+base_url+'stanica/core/add>Dodaj još</a>').fadeIn('normal');
                    $('#addstanica').fadeOut('fast',function(){$('#addstanica').remove()});
                }else{
                    $('#infomessage').html(data.message).fadeIn('normal');
                }
            },
            dataType: 'json'
        });
    });

});