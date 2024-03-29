
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Kreiraj polazak</div>
            <div class="cnt_cnt">
                <div id="infomessage" style="display: none;"></div>
                <form name="addpolazak" id="addpolazak" method="post" action="javascript: void(0);">

                    <div class="lineinput">
                        <label>Prevoznik:</label><br />                 
                        <select name="prevoznik_id" class="inputbox">
                            <option value="0" class="idle">- Molimo odaberite prevoznika - </option>
                            <?
                                foreach ($prevoznici as $prevoznik) {
                                    echo "<option value='". $prevoznik['id'] . "'>" . $prevoznik['naziv'] . ' ' . $prevoznik['grad'] . "</option>";                         
                                }
                            ?>
                        </select>                        
                    </div>

                    <div class="lineinput">
                        <input name="vrstapolaska" id="vrstapolaska_dnevni" value="dnevni" type="radio" checked="checked"> Dnevni
                        <input name="vrstapolaska" id="vrstapolaska_vikendom" value="vikendom" type="radio"> Vikendom
                        <input name="sezonski" id="sezonski" type="checkbox" value="1" > Sezonski 
                    </div>                    

                    <div class="lineinput">
                        <label>Prvi polazak:</label><br />                 
                        <input name="prvipolazak" id="prvipolazak" type="text" class="inputbox short" />                        
                    </div>

                    <div class="lineinput">
                        <label>Zadnji polazak:</label><br />                 
                        <input name="zadnjipolazak" id="zadnjipolazak" type="text" class="inputbox short" />                        
                    </div>

                    <div class="lineinput">
                        <label>Peron:</label><br />                 
                        <input name="peron" id="peron" type="text" class="inputbox" />                        
                    </div>

                    <div class="cnt_ttl clearfix" style="padding: 14px 0 7px;">Ruta i vremena na stop stanicama <div id="ajax_loader"><img src="<?=base_url()?>assets/img/backgnds/ajax-loader2.gif" /></div></div>


                    <? $this->load->view('polazak/stopstanica', array('stoptype'=>'pocetna','id'=>00)); ?>

                    <div id="stopstanice" class="diffbg">
                        
                        <div id="stop-content">
                            <ul class="stanice ui-sortable" id="sortable">
                                <? for($i=1; $i<=5;$i++){  $this->load->view('polazak/stopstanica', array('stoptype'=>'stop','id'=>$i)); } ?>     
                            </ul>

                        </div>
                        <label class="create-stop-label">
                            <a href="javascript:void(0)" class="cmsbtn create-stop">Dodaj stop-stancu</a>
                            <a href="javascript:void(0)" class="stanice_tip nova_stanica">Unesi novu stop-stancu</a>
                            
                        </label><br /> <br />
                        
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

<!--AUTOCOMPLETE-->

<script>

    var stanice = new Array();

    <? foreach ($stanice as $val){ ?> stanice.push('<?=$val?>'); <? } ?>

    $("input.ac_stanica").autocomplete({ source: stanice });         

</script>