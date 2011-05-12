$(function(){     
    // get the current date
    var date = new Date();
    var m = date.getMonth(),
    d = date.getDate() + 1,
    y = date.getFullYear();
    // Datepicker
    $('#prvipolazak').datepicker({ 
        showOn: 'button',
        buttonImage: base_url+'assets/img/backgnds/calendar2.gif',
        buttonImageOnly: true,
        minDate: new Date(y, m, d),
        maxDate: new Date(y, m+12, d),
        dateFormat: 'dd.mm.yy',
        inline:true,
        numberOfMonths: 3

    });

    $('#prvipolazak').click(function(){
        $('#prvipolazak').datepicker("show");  
    });

    $('#zadnjipolazak').datepicker({ 
        showOn: 'button',
        buttonImage: base_url+'assets/img/backgnds/calendar2.gif',
        buttonImageOnly: true,
        minDate: new Date(y, m, d),
        maxDate: new Date(y, m+12, d),
        dateFormat: 'dd.mm.yy',
        inline:true,
        numberOfMonths: 3

    });

    $('#zadnjipolazak').click(function(){
        $('#zadnjipolazak').datepicker("show");  
    }); 

    $("input#nazivi").autocomplete({
        source: ["c++", "java", "php", "coldfusion", "javascript", "asp", "ruby"]
    });        
});