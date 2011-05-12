
$(document).ready(function(){

    $('#editprevoznik').live('submit',function(){
        $.ajax({
            url: base_url+'prevoznik/core/db_edit/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                $.modal.close();
                if(data.success == 'success'){
                    $('#infomessage').css('border-left','4px solid #7c9c59');
                    $('#infomessage').html('Uredili ste prevoznika.<a class="cmsbtn ml-6" href='+base_url+'prevoznik/core/view>Pregledaj</a>').fadeIn('normal');
                    $('#editprevoznik').fadeOut('fast',function(){$('#editprevoznik').remove()});
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