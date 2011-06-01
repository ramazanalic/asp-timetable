$(document).ready(function(){

    // TABLSE SORTER
    var rowCount = $('#prevoznik_tbl tr').length-1;
    $("#prevoznik_tbl").tablesorter({
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
    })/*.tablesorterPager({
        container: $("#prevoznik_pgr"),
        size: 33,
        seperator: ' / ',
        positionFixed: false
    })*/; 

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


    var defaults = {
        speed: 200,
        xOffset: -16,
        yOffset: -380
    };

    $('.stanice_tip').live("mouseover mouseout",

    function (event) {

        if (event.type == "mouseover") {

            $("body").append("<div id='tooltip'></div>");

            var id = this.id;

            $.ajax({

                url : base_url+'polazak/core/pogledaj_stop_stanice',

                type: 'post',

                data: {id_polaska:id},

                dataType:'json',

                success: function(data){

                    $("#tooltip").html(data.html);

                    $("#stop_stanice_tbl").tablesorter({

                        headers: {
                            0: { sorter: false }, 1: { sorter: false }, 2: { sorter: false }, 3: { sorter: false }   
                        },

                        widthFixed: false,

                        widgets: ['zebra']

                    })

                }
            });

            $("#tooltip")

            .css("top", (event.pageY + defaults.xOffset) + "px")

            .css("left", (event.pageX + defaults.yOffset) + "px")

            .fadeIn(defaults.speed);

        }
        else {

            $("#tooltip").remove();

        } 
    });

    $('.stanice_tip').live('mousemove', function(evt){

        $("#tooltip")

        .css("top", (evt.pageY + defaults.xOffset) + "px")

        .css("left", (evt.pageX + defaults.yOffset) + "px");

    })


});