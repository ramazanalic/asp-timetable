$(document).ready(function(){

    // TABLSE SORTER
    $(".tablesorter").tablesorter({
        widthFixed: true,
        widgets: ['zebra'] 

    });


    $('.delete_grid').live('click',function(){
        if(confirm('Brisi?')){
            var id = $(this).attr('id').substr(3);
            $.ajax({
                url : site_url+'excursions/excursions/delete',
                type: 'post',
                data: {id:id},
                dataType:'json',
                success: function(data){
                    $('#ex_'+id).parent().parent().remove();
                }
            });
        }
    });
});