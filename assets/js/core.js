/**
* @author Alexander Farkas
* v. 1.02
*/

(function($) {
    $.extend($.fx.step,{
        backgroundPosition: function(fx) {
            if (fx.state === 0 && typeof fx.end == 'string') {
                var start = $.curCSS(fx.elem,'backgroundPosition');
                start = toArray(start);
                fx.start = [start[0],start[2]];
                var end = toArray(fx.end);
                fx.end = [end[0],end[2]];
                fx.unit = [end[1],end[3]];
            }
            var nowPosX = [];
            nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0];
            nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1];
            fx.elem.style.backgroundPosition = nowPosX[0]+' '+nowPosX[1];

            function toArray(strg){
                strg = strg.replace(/left|top/g,'0px');
                strg = strg.replace(/right|bottom/g,'100%');
                strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");
                var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);
                return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];
            }
        }
    });
})(jQuery);

$(function() {


    /*Home SWF Entrace*/ 

    if((page=='home')||1){
        var so = new FlashObject(base_url+"assets/swf/entrance.swf", "Loader", "880", "116", "8", "#FFF");
        so.addParam("wmode", "transparent");
        so.write('entrance');
    }


    /*Navigation RollOver*/

    if($.browser.msie == false){
       alert ("IE FALSE") 
        $('#main-nav ul li a')
        .css( {backgroundPosition: "0 0"} )
        .mouseover(function(){
            $(this).stop().animate({backgroundPosition:"(0 -250px)"}, {duration:450})
        })
        .mouseout(function(){
            $(this).stop().animate({backgroundPosition:"(0 0)"}, {duration:450}) 
        }) 
    }




    /*Contact Modal Link*/ 

    $('.contact_dialog').click(function() {
        $('#kontakt_div').modal({
            opacity: 60,
            containerCss:{
                width: '669px',
                height: '278px',
                background: 'transparent',
                border: 0,
                padding: 0
            },
            onOpen: function (dialog) {
                dialog.data.hide();
                dialog.overlay.fadeIn('fast', function () {
                    dialog.container.fadeIn('fast', function () {
                        dialog.data.slideDown('normal',function(){
                            $('.zmodalClose').fadeIn('fast');
                        });
                    });
                });
            },
            closeClass: 'zmodalClose'
        });
        $('.zmodalClose').css({
            'margin-right':'35px',
            'margin-top':'46px',
            'display':'none'
        });  
    });


    function loadingmain()
    {
        $.modal(
        "<div><div id='loader'><h2>Please wait...</h2><div class='animate'><img src='"+base_url+"assets/img/backgnds/loadingfinal.gif'></div></div></div>" , {

            closeHTML: "",
            containerCss:{
                height:80,
                width:130,
                borderColor:"#dedede"
            },
            opacity:10,
            overlayCss: {
                backgroundColor: "#000000"
            }  
        });
    }

    $('.cmsbtn').live('click',function(){ loadingmain(); })

});
