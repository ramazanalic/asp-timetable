
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Uredi stanicu / stop stanicu</div>
            <div class="cnt_cnt">
                <div id="infomessage" style="display: none;"></div>
                <form name="editstanica" id="editstanica" method="post" action="javascript: void(0);">

                    <div class="lineinput">
                        <label>
                            Naziv:<br />
                            <input name="naziv" id="naziv" type="text" class="inputbox" value="<?=$stanica['naziv']?>" />
                        </label>
                    </div>

                    <input name="id" id="id" type="hidden" value="<?=$stanica['id']?>" />
                    
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