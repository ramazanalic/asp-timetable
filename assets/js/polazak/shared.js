$(function(){     
    $('.stop-stanica-holder input').live('focus', function() {
        if($(this).val()=='Ostavite prazno da bi obrisali stanicu'){
            $(this).val('');
            $(this).removeClass('idle');
        }
    });
    $('.stop-stanica-holder input').live('blur', function() {
        if($(this).val()==''){
            $(this).addClass('idle');
            $(this).val('Ostavi prazno da bi obrisao odgovor');
        }
    });
    $( "#sortable" ).sortable({
        axis: 'y',
        containment: 'parent',
        handle: '.move',
        tolerance: 'pointer'
    });    
});