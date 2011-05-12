
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
                            <option value="0" class="idle">- Molimo odaberite prevoznika - </option>
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


                    <? $this->load->view('polazak/stopstanica', array('stoptype'=>'pocetna','id'=>00)); ?>

                    <div id="stopstanice" class="diffbg">
                        <div id="stop-content">
                            <ul class="stanice ui-sortable" id="sortable">
                                <? for($i=1; $i<=5;$i++){  $this->load->view('polazak/stopstanica', array('stoptype'=>'stop','id'=>$i)); } ?>     
                            </ul>

                        </div>
                        <label class="create-stop-label"><a href="javascript:void(0)" class="cmsbtn create-stop">Dodaj stop-stancu</a></label><br /> <br />
                    </div>

                    <? $this->load->view('polazak/stopstanica', array('stoptype'=>'zadnja','id'=>01)); ?> 


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