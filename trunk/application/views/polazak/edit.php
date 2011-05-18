
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Uredi polazak</div>
            <div class="cnt_cnt">
                <div id="infomessage" style="display: none;"></div>
                <form name="editpolazak" id="editpolazak" method="post" action="javascript: void(0);">

                    <div class="lineinput">
                        <label>Prevoznik:</label><br />                 
                        <select name="prevoznik_id" class="inputbox">
                            <option value="0" class="idle">- Molimo odaberite prevoznika - </option>
                            <?

                                $selected = '';

                                foreach ($prevoznici as $prevoznik) {

                                    if ($prevoznik['id'] == $polazak['prevoznik_id']) $selected = 'selected = "selected"';

                                    echo "<option value='". $prevoznik['id'] . "'".  $selected . ">" . $prevoznik['naziv'] . ' ' . $prevoznik['grad'] . "</option>";

                                    $selected ='';

                                }

                            ?>
                        </select>
                    </div>

                    <div class="lineinput">
                        <? $checked = 'checked="checked"'; ?>
                        <input name="vrstapolaska" id="vrstapolaska_dnevni" value="dnevni" type="radio" <? if($polazak['dnevni'] == 1) echo $checked; ?>> Dnevni
                        <input name="vrstapolaska" id="vrstapolaska_vikendom" value="vikendom" type="radio" <? if($polazak['vikendom'] == 1) echo $checked; ?>> Vikendom
                        <input name="sezonski" id="sezonski" type="checkbox" value="1" <? if($polazak['sezonski'] == 1) echo $checked; ?>> Sezonski 
                    </div>                    

                    <div class="lineinput">
                        <label>Prvi polazak:</label><br />                 
                        <input name="prvipolazak" id="prvipolazak" type="text" class="inputbox short" value="<?=date('d.m.Y', $polazak['prvipolazak'] ) ?>" />                        
                    </div>

                    <div class="lineinput">
                        <label>Zadnji polazak:</label><br />                 
                        <input name="zadnjipolazak" id="zadnjipolazak" type="text" class="inputbox short" value="<?=date('d.m.Y', $polazak['zadnjipolazak'] ) ?>" />                        
                    </div>

                    <div class="lineinput">
                        <label>Peron:</label><br />                 
                        <input name="peron" id="peron" type="text" class="inputbox" value="<?=$polazak['peron']?>" />                        
                    </div>

                    <div class="cnt_ttl" style="padding: 14px 0 7px;">Ruta i vremena na stop stanicama <div id="ajax_loader"><img src="<?=base_url()?>assets/img/backgnds/ajax-loader2.gif" /></div></div>

                    <? $this->load->view('polazak/stopstanica_edit', array('stoptype'=>'pocetna')); ?>

                    <div id="stopstanice" class="diffbg">
                        <div id="stop-content">
                            <ul class="stanice ui-sortable" id="sortable">

                                <?

                                    $stop_stanice = array_slice($st_stanice, 1, -1);

                                    $i = 1;

                                    foreach($stop_stanice as $st_stanica){

                                        $this->load->view('polazak/stopstanica_edit', array('stoptype'=>'stop', 'id'=>$i, 'res' => $st_stanica));    

                                        $i++;

                                    }

                                ?>
                                <script>rb_stanice = '<?=$i;?>'</script>                                

                            </ul>

                        </div>
                        
                        <label class="create-stop-label">
                            <a href="javascript:void(0)" class="cmsbtn create-stop">Dodaj stop-stancu</a>
                            <a href="javascript:void(0)" class="stanice_tip nova_stanica">Unesi novu stop-stancu</a>
                        </label><br /> <br />
                        
                    </div>

                    <? $this->load->view('polazak/stopstanica_edit', array('stoptype'=>'zadnja')); ?> 

                    <input name="id" id="id" type="hidden" value="<?=$polazak['id']?>" />

                    <div class="lineinput">
                        <label>
                            <input type="submit" value="Uredi" class="cmsbtn" />
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
