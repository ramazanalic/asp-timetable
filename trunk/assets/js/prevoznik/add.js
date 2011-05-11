
$(document).ready(function(){

    $('#addprevoznik').live('submit',function(){
        $.ajax({
            url: base_url+'prevoznik/core/db_add/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                $.modal.close();
                if(data.success == 'success'){
                    $('#infomessage').html('Dodali ste prevoznika.<br /><a class="cmsbtn" href='+base_url+'prevoznik/core/add>Dodaj još</a>').fadeIn('normal');
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