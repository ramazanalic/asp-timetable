<?
    switch($stoptype){


        case 'pocetna':

            $first = reset($st_stanice); 

        ?>

        <div class="stopstanica clearfix prva">

            <div class="lineinput">
                <label>Početna stanica:</label><br />                            
                <input name="pocetna_stanica" id="pocetna_stanica" type="text" class="inputbox ac_stanica" value="<?=$first['naziv_stanice']?>" />                        
            </div>

            <div class="lineinput">
                <label>Vrijeme polaska:</label><br />                 
                <? echo makefull('vrijemepolaska_pocetna' , 5 , 'id="vrijemepolaska_pocetna"' , 'class="inputbox vrijemepolaska"' , date('H:i',$first['vrijemepolaska'])); ?>                        
            </div>

            <div class="lineinput space"></div>

            <div class="lineinput">
                <label>KM:</label><br />                            
                <input name="km_pocetna" id="km_pocetna" type="text" class="inputbox km" value="<?=$first['km']?>" />                        
            </div>

        </div>

        <?break;



        case 'stop':?>

        <li>
            <div class="stopstanica clearfix diffbg">
                <div class="lineinput">
                    <div class="move"><img height="14" width="14" src="<?=base_url()?>/assets/img/backgnds/ico-move.png"></div>
                </div>

                <div class="lineinput stop-stanica-holder">
                    <label>Stop stanica:</label><br />                            
                    <input name="stanica[]" id="stanica_<?=$id?>" type="text" class="inputbox ac_stanica" value="<?=$res['naziv_stanice']?>" />                        
                </div>

                <div class="lineinput">
                    <label>Vrijeme polaska:</label><br />                 
                    <? echo makefull('vrijemepolaska[]' , 5 , 'id="vrijemepolaska-'.$id.'"' , 'class="inputbox vrijemepolaska"' , date('H:i',$res['vrijemepolaska'])); ?>                        
                </div>

                <div class="lineinput">
                    <label>Vrijeme dolaska:</label><br />                 
                    <? echo makefull('vrijemedolaska[]' , 5 , 'id="vrijemedolaska-'.$id.'"' , 'class="inputbox vrijemedolaska"' , date('H:i',$res['vrijemedolaska'])); ?>                        
                </div>                        

                <div class="lineinput">
                    <label>KM:</label><br />                            
                    <input name="km[]" id="km_<?=$id?>" type="text" class="inputbox km" value="<?=$res['km']?>" />                        
                </div>

                <div class="lineinput">
                    <label></label><br /> 
                    <a href="javascript:void(0)" class="cmsbtnsml delete-stop">Briši</a>
                </div>

            </div>
        </li>

        <?break;


        case 'zadnja':
        
        $last = end($st_stanice);
        
        ?>

        <div class="stopstanica clearfix zadnja">

            <div class="lineinput">
                <label>Zadnja stanica:</label><br />                            
                <input name="zadnja_stanica" id="zadnja_stanica" type="text" class="inputbox ac_stanica" value="<?=$last['naziv_stanice']?>" />                        
            </div>

            <div class="lineinput space"></div>

            <div class="lineinput">
                <label>Vrijeme dolaska:</label><br />                 
                <? echo makefull('vrijemedolaska_zadnja' , 5 , 'id="vrijemedolaska_zadnja"' , 'class="inputbox vrijemedolaska"' , date('H:i',$last['vrijemedolaska'])); ?>                        
            </div>

            <div class="lineinput">
                <label>KM:</label><br />                            
                <input name="km_zadnja" id="km_zadnja" type="text" class="inputbox km" value="<?=$last['km']?>" />                        
            </div> 

        </div>

        <?break;
    }
?>
