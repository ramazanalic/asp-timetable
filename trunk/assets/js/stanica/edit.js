
$(document).ready(function(){

    $('#editstanica').live('submit',function(){
        $.ajax({
            url: base_url+'stanica/core/db_edit/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                $.modal.close();
                if(data.success == 'success'){
                    $('#infomessage').css('border-left','4px solid #7c9c59');
                    $('#infomessage').html('Uredili ste stanicu.<a class="cmsbtn ml-6" href='+base_url+'stanica/core/view>Pregledaj</a>').fadeIn('normal');
                    $('#editstanica').fadeOut('fast',function(){$('#editstanica').remove()});
                }else{
                    $('#infomessage').html(data.message).fadeIn('normal');
                }
            },
            dataType: 'json'
        });
    });

});