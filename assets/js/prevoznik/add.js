
$(document).ready(function(){

    $('#addprevoznik').live('submit',function(){
        $.ajax({
            url: base_url+'prevoznik/core/add/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                if(data.success == 'success'){
                    $('#infomessage').html('Dodali ste prevoznika.').fadeIn('normal');
                    $('#addprevoznik').fadeOut('normal',function(){$('#addprevoznik').remove()});
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