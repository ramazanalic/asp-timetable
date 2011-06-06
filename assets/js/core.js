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

/*Jquery Busy.min*/
(function($){function Busy(a){this.options=$.extend({},Busy.defaults,a)};Busy.instances=[];Busy.repositionAll=function(){for(var i=0;i<Busy.instances.length;i++){if(!Busy.instances[i])continue;var a=Busy.instances[i].options;new Busy(a).positionImg($(Busy.instances[i].target),$.data(Busy.instances[i].target,"busy"),a.position)}};Busy.prototype.hide=function(b){b.each(function(){var a=$.data(this,"busy");if(a)a.remove();$(this).css("visibility","");$.data(this,"busy",null);for(var i=0;i<Busy.instances.length;i++)if(Busy.instances[i]!=null&&Busy.instances[i].target==this)Busy.instances[i]=null})};Busy.prototype.show=function(c){var d=this;c.each(function(){if($.data(this,"busy"))return;var a=$(this);var b=d.buildImg();b.css("visibility","hidden");b.load(function(){d.positionImg(a,b,d.options.position);b.css("visibility","")});$("body").append(b);if(d.options.hide)a.css("visibility","hidden");$.data(this,"busy",b);Busy.instances.push({target:this,options:d.options})})};Busy.prototype.preload=function(){var a=this.buildImg();a.css("visibility","hidden");a.load(function(){$(this).remove()});$("body").append(a)};Busy.prototype.buildImg=function(){var a="<img src='"+this.options.img+"' alt='"+this.options.alt+"' title='"+this.options.title+"'";if(this.options.width)a+=" width='"+this.options.width+"'";if(this.options.height)a+=" height='"+this.options.height+"'";a+=" />";return $(a)};Busy.prototype.positionImg=function(a,b,c){var d=a.offset();var e=a.outerWidth();var f=a.outerHeight();var g=b.outerWidth();var h=b.outerHeight();if(c=="left"){var i=d.left-g-this.options.offset}else if(c=="right"){var i=d.left+e+this.options.offset}else{var i=d.left+(e-g)/2.0}var j=d.top+(f-h)/2.0;b.css("position","absolute");b.css("left",i+"px");b.css("top",j+"px")};Busy.defaults={img:'busy.gif',alt:'Please wait...',title:'Please wait...',hide:true,position:'center',zIndex:1001,width:null,height:null,offset:10};$.fn.busy=function(a,b){if($.inArray(a,["clear","hide","remove"])!=-1){new Busy(a).hide($(this))}else if(a=="defaults"){$.extend(Busy.defaults,b||{})}else if(a=="preload"){new Busy(a).preload()}else if(a=="reposition"){Busy.repositionAll()}else{new Busy(a).show($(this));return $(this)}}})(jQuery);

$(function() {


    /*Home SWF Entrace*/ 

    if((page=='home')||1){
        var so = new FlashObject(base_url+"assets/swf/entrance-load.swf", "Loader", "880", "116", "8", "#FFF");
        so.addVariable("p", base_url+"assets/swf/entrance.swf");
        so.addParam("wmode", "transparent");
        //so.write('entrance');
    }


    /*Navigation RollOver*/


    $('#main-nav ul li a')
    .css( {backgroundPosition: "0 0"} )
    .mouseover(function(){
        $(this).stop().animate({backgroundPosition:"(0 -250px)"}, {duration:450})
    })
    .mouseout(function(){
        $(this).stop().animate({backgroundPosition:"(0 0)"}, {duration:450}) 
    }) 





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
