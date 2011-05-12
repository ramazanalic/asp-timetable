
$(document).ready(function(){

    $('#addprevoznik').live('submit',function(){
        $.ajax({
            url: base_url+'prevoznik/core/db_add/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                $.modal.close();
                if(data.success == 'success'){
                    $('#infomessage').css('border-left','4px solid #7c9c59'); 
                    $('#infomessage').html('Dodali ste prevoznika.<a class="cmsbtn ml-6" href='+base_url+'prevoznik/core/add>Dodaj još</a>').fadeIn('normal');
                    $('#addprevoznik').fadeOut('fast',function(){$('#addprevoznik').remove()});
                }else{
                    $('#infomessage').html(data.message).fadeIn('normal');
                }
            },
            dataType: 'json'
        });
    });
    tinyMCE.init({
        mode : "textareas",
        theme : "simple"
    });
});