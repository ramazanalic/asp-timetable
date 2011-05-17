$(document).ready(function(){

    // TABLSE SORTER
    var rowCount = $('#prevoznik_tbl tr').length;
    $("#prevoznik_tbl").tablesorter({
        // pass the headers argument and assing a object
        headers: {
            7: {
                sorter: false
            },
            8: {
                sorter: false
            }
        },
        widthFixed: false,
        widgets: ['zebra']
    }).tablesorterPager({
        container: $("#prevoznik_pgr"),
        size: 5,
        seperator: ' / ',
        positionFixed: false
    }); 

    $('.tbl_total').html(rowCount);
    $('.tbl_subtitle').html('polazaka');

    $('.delete_grid').live('click',function(){
        if(confirm('Briši?')){

            //Must be 2 char length with _  -  #pz_

            var id = $(this).attr('id').substr(3);
            $.ajax({
                url : base_url+'polazak/core/db_delete',
                type: 'post',
                data: {id:id},
                dataType:'json',
                success: function(data){
                    $('#pz_'+id).parent().parent().remove();
                }
            });
        }
    });

   
    /* Toll tip */
   
    $('.stanice_tip').quicktip({
        speed:100,
        xOffset:-16,
        yOffset:-380,
        elem:'#tip_cont'
    });

    


});