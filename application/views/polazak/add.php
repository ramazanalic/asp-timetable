
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Kreiraj polazak</div>
            <div class="cnt_cnt">
                <div id="infomessage" style="display: none;"></div>
                <form name="addprevoznik" id="addprevoznik" method="post" action="javascript: void(0);">

                    <div class="lineinput">
                        <label>Prevoznik:</label><br />                 
                        <select name="prevoznik_id" class="inputbox">
                            <option value="0">- Molimo odaberite prevoznika - </option>
                            <?
                                $weekday = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

                                foreach ($prevoznici as $prevoznik) {
                                    echo "<option value='". $prevoznik['id'] . "'>" . $prevoznik['naziv'] . ' ' . $prevoznik['grad'] . "</option>";                         
                                }
                            ?>
                        </select>                        
                    </div>

                    <div class="lineinput">
                        <input name="vrstapolaska" value="dnevni" type="RADIO" > Dnevni
                        <input name="vrstapolaska" value="vikendom" type="RADIO" > Vikendom
                        <input name="sezonski" id="sezonski" type="checkbox" > Sezonski 
                    </div>                    

                    <div class="lineinput">
                        <label>Prvi polazak:</label><br />                 
                        <input name="prvipolazak" id="prvipolazak" type="text" class="inputbox short" disabled="disabled" />                        
                    </div>

                    <div class="lineinput">
                        <label>Zadnji polazak:</label><br />                 
                        <input name="zadnjipolazak" id="zadnjipolazak" type="text" class="inputbox short" disabled="disabled" />                        
                    </div>

                    <div class="lineinput">
                        <label>Peron:</label><br />                 
                        <input name="peron" id="peron" type="text" class="inputbox" />                        
                    </div>

                    <div class="cnt_ttl" style="padding: 14px 0 7px;">Ruta i vremena na stop stanicama</div>

                    <div class="stopstanica clearfix">

                        <div class="lineinput">
                            <label>Polazna stanica:</label><br />                            
                            <input name="stanica" id="nazivi" type="text" class="inputbox tagger" />                        
                        </div>
                        
                        <div class="lineinput">
                            <label>Vrijeme polaska:</label><br />                 
                            <? echo makefull('vrijemepolaska',5,'id="vrijemepolaska"','class="inputbox"'); ?>                        
                        </div>
                        
                        <div class="lineinput">
                            <label>Vrijeme dolaska:</label><br />                 
                            <? echo makefull('vrijemedolaska',5,'id="vrijemedolaska"','class="inputbox"'); ?>                        
                        </div>
                        
                        <div class="lineinput">
                            <label>KM:</label><br />                            
                            <input name="km" id="km" type="text" class="inputbox" />                        
                        </div>

                    </div>
                    
                    <div class="stopstanica clearfix">

                        <div class="lineinput">
                            <label>Stop stanica:</label><br />                            
                            <input name="stanica" id="nazivi" type="text" class="inputbox tagger" />                        
                        </div>
                        
                        <div class="lineinput">
                            <label>Vrijeme polaska:</label><br />                 
                            <? echo makefull('vrijemepolaska',5,'id="vrijemepolaska"','class="inputbox"'); ?>                        
                        </div>
                        
                        <div class="lineinput">
                            <label>Vrijeme dolaska:</label><br />                 
                            <? echo makefull('vrijemedolaska',5,'id="vrijemedolaska"','class="inputbox"'); ?>                        
                        </div>
                        
                        <div class="lineinput">
                            <label>KM:</label><br />                            
                            <input name="km" id="km" type="text" class="inputbox" />                        
                        </div>

                    </div>

                    <div class="stopstanica zadnja clearfix">

                        <div class="lineinput">
                            <label>Zadnja stanica:</label><br />                            
                            <input name="stanica" id="nazivi" type="text" class="inputbox tagger" />                        
                        </div>
                        
                        <div class="lineinput">
                            <label>Vrijeme polaska:</label><br />                 
                            <? echo makefull('vrijemepolaska',5,'id="vrijemepolaska"','class="inputbox"'); ?>                        
                        </div>
                        
                        <div class="lineinput">
                            <label>Vrijeme dolaska:</label><br />                 
                            <? echo makefull('vrijemedolaska',5,'id="vrijemedolaska"','class="inputbox"'); ?>                        
                        </div>
                        
                        <div class="lineinput">
                            <label>KM:</label><br />                            
                            <input name="km" id="km" type="text" class="inputbox" />                        
                        </div>

                    </div>

                    <div class="lineinput">
                        <label>
                            <input type="submit" value="Dodaj" class="cmsbtn" />
                        </label>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>