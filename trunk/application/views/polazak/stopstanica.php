<?
    switch($stoptype){


        case 'pocetna':?>

        <div class="stopstanica clearfix prva">

            <div class="lineinput">
                <label>Početna stanica:</label><br />                            
                <input name="stanica-<?=$id?>" id="stanica-<?=$id?>" type="text" class="inputbox" />                        
            </div>

            <div class="lineinput">
                <label>Vrijeme polaska:</label><br />                 
                <? echo makefull('vrijemepolaska-'.$id.'',5,'id="vrijemepolaska-'.$id.'"','class="inputbox vrijemepolaska"'); ?>                        
            </div>

            <div class="lineinput space"></div>

            <div class="lineinput">
                <label>KM:</label><br />                            
                <input name="km-<?=$id?>" id="km-<?=$id?>" type="text" class="inputbox km" />                        
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
                    <input name="stanica-<?=$id?>" id="stanica-<?=$id?>" type="text" class="inputbox idle" value="Ostavite prazno da bi obrisali stanicu" />                        
                </div>

                <div class="lineinput">
                    <label>Vrijeme polaska:</label><br />                 
                    <? echo makefull('vrijemepolaska-'.$id.'',5,'id="vrijemepolaska-'.$id.'"','class="inputbox vrijemepolaska"'); ?>                        
                </div>

                <div class="lineinput">
                    <label>Vrijeme dolaska:</label><br />                 
                    <? echo makefull('vrijemedolaska-'.$id.'',5,'id="vrijemedolaska-'.$id.'"','class="inputbox vrijemedolaska"'); ?>                        
                </div>

                <div class="lineinput">
                    <label>KM:</label><br />                            
                    <input name="km-<?=$id?>" id="km-<?=$id?>" type="text" class="inputbox km" />                        
                </div>

                <div class="lineinput">
                    <label></label><br /> 
                    <a href="javascript:void(0)" class="cmsbtnsml delete-stop">Briši</a>
                </div>

            </div>
        </li>

        <?break;


        case 'zadnja':?>

        <div class="stopstanica clearfix zadnja">

            <div class="lineinput">
                <label>Zadnja stanica:</label><br />                            
                <input name="stanica-<?=$id?>" id="stanica-<?=$id?>" type="text" class="inputbox"  />                        
            </div>

            <div class="lineinput space"></div>

            <div class="lineinput">
                <label>Vrijeme dolaska:</label><br />                 
                <? echo makefull('vrijemedolaska-'.$id.'',5,'id="vrijemedolaska-'.$id.'"','class="inputbox vrijemedolaska"'); ?>                        
            </div>

            <div class="lineinput">
                <label>KM:</label><br />                            
                <input name="km-<?=$id?>" id="km-<?=$id?>" type="text" class="inputbox km" />                        
            </div> 

        </div>

        <?break;
    }
?>
