/*//JQuery Quick Tip
//Author: Owain Lewis
//Author URL: www.Owainlewis.com

jQuery.fn.quicktip = function(options){

    var defaults = {
        speed: 500,
        xOffset: 10,
        yOffset: 10,
        elem:'#tip_cont'
    };

    var options = $.extend(defaults, options);

    return this.each(function(){

        var $this = jQuery(this)

        $(this).css('cursor', 'pointer')  
        

        $(this).hover(function(e){
            
            $("body").append("<div id='tooltip'></div>");  
 
            var id = $(this).attr('id');

            $.ajax({
                url : base_url+'polazak/core/pogledaj_stop_stanice',
                type: 'post',
                data: {id_polaska:id},
                dataType:'json',
                success: function(data){
                    $("#tooltip").html(data.html);

                    $("#stop_stanice_tbl").tablesorter({

                        headers: {
                            0: {
                                sorter: false
                            },
                            1: {
                                sorter: false
                            },
                            2: {
                                sorter: false
                            },
                            3: {
                                sorter: false
                            }
                        },
                        widthFixed: false,
                        widgets: ['zebra']
                    })

                }
            });


            $("#tooltip")
            .
            css("top", (e.pageY + defaults.xOffset) + "px")
            .css("left", (e.pageX + defaults.yOffset) + "px")
            .fadeIn(options.speed);


        }, function() {
            //Remove the tooltip from the DOM
            $("#tooltip").remove();
        });

        $(this).mousemove(function(e) {
            $("#tooltip")
            .css("top", (e.pageY + defaults.xOffset) + "px")
            .css("left", (e.pageX + defaults.yOffset) + "px");
        });

    });

};


*/