$(document).ready(function(){
   
   
    $('.tagger').each(function(i){
        
        $(this).data('name', $(this).attr('name'));
        
        $(this).removeAttr('name');
        
        
        var b = $('<button type="button" class="cmsbtnsml" style="margin-left: 7px;">Dodaj</button>').addClass('tagAdd')
        .click(function(){
            var tagger = $(this).data('tagger');
            $(tagger).addTag( $(tagger).val() );
            $(tagger).val('');
            $(tagger).stop();
        })
        .data('tagger', this);
        
        var l = $('<ul />').addClass('tagList');
        
        $(this).data('list', l);
        
        $(this).after(l).after(b);
    })
    .bind('keypress', function(e){
        
        if( 13 == e.keyCode){
            $(this).addTag( $(this).val() );
            $(this).val('');
            $(this).stop();
            return false;
        }
        
    }); 
    
    
    /*$('#addtour').live('submit',function(){
        var numItems = $('.tagName').length
        if(numItems==0){
            alert ("Please select at least one departure date")
        }
        $.ajax({
            url: site_url+'tours/tours/update',
            data: $(this).serialize(),
            type: 'POST',
            dataType:'json',
            success:function(data){
                if(data.success == 'success'){
                    $('#infomessage').html('Uredili ste turu.').fadeIn('normal');
                    $('#addtour').remove();
                }else{
                    $('#infomessage').html(data.message).fadeIn('normal');
                }
            }
        });

    }); */
});