/*
*      ADD EXCURSION JS FILE
*      28.05.2010
*/

$(document).ready(function(){

    $('#addexcursion').live('submit',function(){
        $.ajax({
            url: site_url+'index.php/excursions/excursions/update/',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                if(data.success == 'success'){
                    $('#infomessage').html('Uredili ste izlet.').fadeIn('normal');
                    $('#addexcursion').fadeOut('normal',function(){$('#addexcursion').remove()});
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