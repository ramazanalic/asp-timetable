$(function(){  
    
    $.ajax({
            url: base_url+'stanica/core/ajax_ac_complete/',
            type: 'POST',
            success: function(data){
                $("input.ac_stanica").autocomplete({ source: data.html }); 
            },
            dataType: 'json'
        });
    
    
    $('#trazi').live('click', function(){
        
        $.ajax({
            type: 'GET',
            url: base_url+'search/core/search/?jsoncall=?',
            data: ({ 
                
                srch_polazak : $('#srch_polazak').val(),
                srch_dolazak : $('#srch_dolazak').val()  
                
            }),
            dataType: 'jsonp',
            success: function(data){
                
                if(data.success==true){
                    
                    $('#infomessage_search').hide();
                    $('#polasci_tbl tbody').html(data.html);
                    $('#paginator').html(data.paginator);
                    $('.tbl_total').html(data.count);
                    $('#pregled_pretraga').show();
                    
                }else{
                    
                    $('#infomessage_search').show();
                    $('#infomessage_search').html(data.html);
                    
                }  
                             
                $.modal.close();
                
            },
            error:function(data){
                $.modal.close(); 
                alert("Error: " + data);
            }
        });
    })
});