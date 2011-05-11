
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Dodaj prevoznika</div>
            <div class="cnt_cnt">
                <div id="infomessage" style="display: none;"></div>
                <form name="addprevoznik" id="addprevoznik" method="post" action="javascript: void(0);">
                    
                    <div class="lineinput">
                        <label>
                            Naziv:<br />
                            <input name="naziv" id="naziv" type="text" class="inputbox" />
                        </label>
                    </div>
                    
                    <div class="lineinput">
                        <label>
                            Grad:<br />
                            <input name="grad" id="grad" type="text" class="inputbox" />
                        </label>
                    </div>

                    <div class="lineinput">
                        <label>
                            Kratak opis:<br />
                            <textarea name="opis" id="opis" rows="5" class="inputbox tinymce" cols="40"></textarea>
                            <i>kratak opis prevoznika</i> 
                        </label>
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