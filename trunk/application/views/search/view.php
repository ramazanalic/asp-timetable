<style> .main-table-style table tr td{ line-height : 16px; } </style>
<style> .main-table-style table tr td { font-size: 12px; line-height: 16px; color: #000066; } </style>
<style> .main-table-style table tr.header-row { height: 38px; }</style>

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
            <div id="pregled_pretraga" style="display: none;">
                <div class="cnt_ttl">Pregled polazaka</div>
                <div class="cnt_cnt main-table-style"   style="position: relative; width: 640px;">
                    <div id="infomessage">

                    </div>

                    <table class="tablesorter" id="polasci_tbl" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr class="header-row">
                                <th width="10">ID</th>
                                <th width="40">Vrijeme<br />polaska</th>
                                <th width="40">Vrijeme<br />dolaska</th>
                                <th>Tip polaska</th>
                                <th>Prevoznik</th>
                                <th>Peron</th>
                                <th style="text-align: center;">Stanice</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div id="prevoznik_pgr" class="pager">
                        <? $this->load->view('tb-sort-pager')?>    
                    </div>
                    <i>* Polasci su sortirani po nazivu prevoznika.</i>
                </div>
            </div>                       
        </div>
    </div>
</div>

