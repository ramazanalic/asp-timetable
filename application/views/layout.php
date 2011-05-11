<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />        
        <meta name="keywords" content="Autobuska, Autobuska stanica podgorica, asp.co.me, putovanja, prevoz, autobus, stanica, autobuski prevoznik, putovanje crna gora, autobuska crna gora, prevoz podorica, autobuska podgorica, prevoznik podgorica, bus podgorica, putovanje podgorica, stanica podgorica, autobuska stanica" />
        <meta name="description" content="Autobuska stanica Podgorica je locirana na Trgu Golootčkih žrtava. Više od 300 autobuskih polazaka dnevno, 100 prevoznika i preko milion korisnika usluga godišnje. Sadržaji koji su dostupni putnicima i građanima - kafei, prodavnice, restoran, pošta, banka, renta a car, usluge turističke agencije, brodske i avio karte, ATM automati, platni terminal, wireless Internet." />
        <meta name="Language" content="en" />
        <meta name="Robots" content="index,follow" />
        <meta name="Author" content="Kukic Ivan # ikukic@yahoo.com" />
        <meta name="revisit-after" content="2 days" />
        <meta name="Distribution" content="global" />
        <title>Autobuska stanica Podgorica | Mjesto dobrih putovanja | Free Parking</title>  
        <link rel="icon" href="#" type="image/x-icon" />       


        <script type="text/javascript" 
            src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            // You may specify partial version numbers, such as "1" or "1.3",
            //  with the same result. Doing so will automatically load the 
            //  latest version matching that partial revision pattern 
            //  (e.g. 1.3 would load 1.3.2 today and 1 would load 1.5.1).
            google.load("jquery", "1.5.1");

            google.setOnLoadCallback(function() {
                // Place init code here instead of $(document).ready()
                //$(document).ready(function(){  

                //});
            });
        </script>


        <!-- Set base and site url JS -->
        <script type="text/javascript">
            var base_url = '<?=base_url()?>';
            var site_url = '<?=site_url()?>';
            var page = '<?=$page?>';
        </script>

        <?  
            $this->carabiner->display('css');     
            $this->carabiner->display('js');     
        ?>

        <!-- Google analitics -->
        <!--<script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-22094931-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>-->
        
        <!--[if lt IE 7]>
        <script src="<?=base_url()?>assets/js/DD_belatedPNG_0.0.8a-min.js"></script>
        <script>
        window.onload = function() {
        DD_belatedPNG.fix('.png_bg'); 
        };
        </script> 
        <![endif]-->
    </head>
    <body id="<?=$page;?>">
        <div id="header" > <? $this->load->view('header'); ?> </div>
        <div id="wrap">
        <div class="col-mid">
            <div id="main-nav">  <? $this->load->view('nav'); ?> </div>      
            <div class="clear"></div>
            <div id="main-cont"> <? $this->load->view('inner'); ?> </div>            
        </div>                                                                                     
    </body>
</html>
