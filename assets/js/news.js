$(function() {

    /*  AGENCY NEWS SYSTEM ID 
    *   NEWS COUNTER
    *   NEWS DATA
    *   NEWS TOTAL
    */
    var LS_ac_id = 33;
    var cnt=0;
    var news
    var total;
    var base_url = 'http://localhost/logicsol_news/';
    base_url = 'http://vijesti.logicsolution.rs/';
    function citaj_podatke(){
        jQuery.ajax({
            type: 'GET',
            url: base_url+'onsite_news/citaj_podatke/'+LS_ac_id+'/?jsoncall=?',
            dataType: 'jsonp',
            success: function(data){
                news = data;
                total = news['jsonp'].length;
                populate();
            },
            error:function(data){alert("Error: " + data);}
        });
        return false;
    }

    function populate(){
        timeStamp = new Date(news['jsonp'][cnt].created*1000);

        var d = new Date(timeStamp);
        var months = [
        'Jan', 'Feb', 'Mar', 'Apr',
        'May', 'Jun', 'Jul', 'Aug',
        'Sept', 'Oct', 'Nov', 'Dec'
        ];

        var final_date = d.getDate()+'. '+months[d.getMonth()] +' '+ d.getFullYear()+'.';

        jQuery('#news .main .title #created').html('Podgorica<br />'+final_date);
        jQuery('#news .main .title h4').html(news['jsonp'][cnt].title);
        jQuery('#news .main .cont-1 p').html(news['jsonp'][cnt].text);
        if(news['jsonp'][cnt].foto_path==""){
            jQuery('#news .image').html("")    
        }else{
            jQuery('#news #image').html('<img width="680" height="260" src="'+base_url+'assets/upload/fotografije/'+news['jsonp'][cnt].foto_path+'">');
        }
    }
    citaj_podatke();

});