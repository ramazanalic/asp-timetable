$(document).ready(function(){

    // TABLSE SORTER
    var rowCount = $('#stanica_tbl tr').length-1;
    $("#stanica_tbl").tablesorter({
        // pass the headers argument and assing a object
        headers: {
            2: {
                sorter: false
            }
        },
        widthFixed: false,
        widgets: ['zebra']
    }).tablesorterPager({
        container: $("#prevoznik_pgr"),
        size: 10,
        seperator: ' / ',
        positionFixed: false
    }); 

    $('.tbl_total').html(rowCount);


    $('.delete_grid').live('click',function(){
        if(confirm('Briši?')){
            
            //Must be 2 char length with _  -  #pz_
            
            var id = $(this).attr('id').substr(3);
            $.ajax({
                url : base_url+'stanica/core/db_delete',
                type: 'post',
                data: {id:id},
                dataType:'json',
                success: function(data){
                    $('#pz_'+id).parent().parent().remove();
                }
            });
        }
    });
});