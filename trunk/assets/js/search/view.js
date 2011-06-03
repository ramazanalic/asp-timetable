$(document).ready(function(){

    // TABLSE SORTER
    //var rowCount = $('#polasci_tbl tr').length-1;

    $("#polasci_tbl").tablesorter({

        headers: { 5: { sorter: false } },

        widthFixed: false,

        widgets: ['zebra']

    }); 

    //$('.tbl_total').html(rowCount);
    //$('.tbl_subtitle').html('polazaka');


    var defaults = {
        speed: 100,
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

            .css("left", ($("#polasci_tbl").offset().left) + "px")

            .fadeIn(defaults.speed);

        }
        else {

            $("#tooltip").remove();

        } 
    });

    $('.stanice_tip').live('mousemove', function(evt){

        $("#tooltip")

        .css("top", (evt.pageY + defaults.xOffset) + "px");

        //.css("left", (evt.pageX + defaults.yOffset) + "px");

    })


    $("#prevoznik_pgr a").live('click', function(evt) {               
        
        evt.preventDefault();

        $.ajax({
            type: 'GET',
            url:  $(this).get()+'/?jsoncall=?',
            data: ({ 
                srch_polazak : $('#srch_polazak').val(),
                srch_dolazak : $('#srch_dolazak').val()  
            }),
            dataType: 'jsonp',
            success: function(data){

                $('#infomessage_search').hide();
                $('#polasci_tbl tbody').html(data.html);
                $('#paginator').html(data.paginator);

            },
            error:function(data){
                $.modal.close(); 
                alert("Error: " + data);
            }
        });

    });            

    return false;

});