<style> .main-table-style table tr td{ line-height : 16px; } </style>
<style> .main-table-style table tr td { font-size: 11px; line-height: 16px; } </style>

<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">
            <div class="cnt_ttl">Pretraži polaske</div> 
            <div id="pretrazivac">
                <div id="infomessage_search" style="display: none;">

                </div>

                <div style="float: right; margin: 32px 10px 0;">
                    <a href="javascript:void(0)" id="trazi" class="cmsbtn-noloader" style="background: none #EA1B2F;">PRIKAŽI POLASKE</a>
                </div>

                <div class="lineinput mr-30">
                    <label>POLAZNA STANICA:</label><br />                 
                    <input name="srch_polazak" id="srch_polazak" type="text" class="inputbox ac_stanica" />                        
                </div>

                <div class="lineinput">
                    <label>DOLAZNA STANICA:</label><br />                 
                    <input name="srch_dolazak" id="srch_dolazak" type="text" class="inputbox ac_stanica" />                        
                </div>

                <div class="clear"></div>               

            </div>                       
            <div class="cnt_ttl">Pregled polazaka</div>
            <div class="cnt_cnt main-table-style"   style="position: relative;">
                <div id="infomessage">

                </div>

                <table class="tablesorter" id="prevoznik_tbl" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr class="header-row">
                            <th width="20" style="text-align: center;">ID</th>
                            <th width="80">Polazak od/do</th>
                            <th>Vrijeme</th>
                            <th>Tip</th>
                            <th width="140">Prevoznik</th>
                            <th>Važi od/do</th>
                            <th>Peron</th>
                            <th width="50" style="text-align: center;">Stanice</th>
                            <th width="80" style="text-align: center;">Akcija</th>

                        </tr>
                    </thead>
                    <tbody>
                        <? $this->load->view('polazak/search'); ?>
                    </tbody>
                </table>
                <div id="prevoznik_pgr" class="pager">
                    <? $this->load->view('tb-sort-pager')?>    
                </div>

                <div class="note_box">
                    <div class="note_body clearfix">
                        
                        <div class="left_note">
                            <strong class="note_title">Napomena:</strong>
                        </div>
                        
                        <div class="right_note">
                            <ul>
                                <li>Vrijeme polaska odnosi se na početnu stanicu.</li>
                                <li>Prije pretrage, polasci su sortirani po nazivu prevoznika.</li>
                            </ul>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

