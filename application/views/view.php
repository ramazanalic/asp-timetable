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
                        <a href="javascript:void(0)" id="trazi" class="cmsbtn" style="background: none #EA1B2F;">PRIKAŽI POLASKE</a>
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
                            <th width="80">DESTINACIJA OD/DO</th>
                            <th>VRIJEME</th>
                            <th>TIP POLASKA</th>
                            <th width="140">PREVOZNIK</th>
                            <th>VAŽI OD/DO</th>
                            <th>PERON</th>
                            <th style="text-align: center;">STANICE</th>
                            <th width="100" style="text-align: center;">AKCIJA</th>

                        </tr>
                    </thead>
                    <tbody>
                        <? $this->load->view('polazak/search'); ?>
                    </tbody>
                </table>
                <div id="prevoznik_pgr" class="pager">
                    <? $this->load->view('tb-sort-pager')?>    
                </div>
                <i>* Polasci su sortirani po nazivu.</i>
            </div>
        </div>
    </div>
</div>

