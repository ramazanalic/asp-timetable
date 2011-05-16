<style> .main-table-style table tr td{ line-height : 16px; } </style>

<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Pregled polazaka</div>
            <div class="cnt_cnt main-table-style"   style="position: relative;">
                <div id="infomessage" style="display: block;">
                <div id="stanice_tooltip">
                    Test tooltip!
                </div>
                </div>
                
                <table class="tablesorter" id="prevoznik_tbl" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr class="header-row">
                            <th width="30" style="text-align: center;">ID</th>
                            <th>DESTINACIJA OD/DO</th>
                            <th>VRIJEME</th>
                            <th>TIP POLASKA</th>
                            <th>PREVOZNIK</th>
                            <th>VAŽI OD/DO</th>
                            <th>PERON</th>
                            <th>STANICE</th>
                            <th style="text-align: center;">AKCIJA</th>

                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($polasci as $polazak): ?>
                            <tr>
                                <td style="text-align: center;"><?=$polazak['id']?></td>
                                <td><strong><?=$polazak['pocetnastanica'].' <br />'. $polazak['zadnjastanica']?></strong></td>                    
                                <td><strong><?=date('H.s',$polazak['vrijemepolaska']).'h <br />'. date('H.s',$polazak['vrijemedolaska']).'h';?></strong></td>                    
                                <td>
                                    <?
                                        if($polazak['dnevni'] == 1) echo 'Dnevni';
                                        if($polazak['vikendom'] == 1) echo 'Vikendom';
                                        if($polazak['sezonski'] == 1) echo ' - sezonski';
                                    ?>
                                </td>
                                <td> <?=$polazak['naziv_prevoznika']. '<br />'.$polazak['grad_prevoznika']; ?> </td>    
                                <td><?=date('d.m.Y',$polazak['prvipolazak']).'<br />'. date('d.m.Y',$polazak['zadnjipolazak']);?></td>                    
                                <td><?=$polazak['peron'];?></td>
                                <td><a href="javacript:void(0)" class="stanice_tip">POGLEADJ</a></td>

                                <td style="text-align: center; padding-top: 4px;" class="actiontd">
                                    <a href="<?=base_url();?>prevoznik/core/edit/<?=$polazak['id'];?>" class="edit_grid cmsbtnsml" id="<?=$polazak['id']?>">Uredi</a> 
                                    <a href="javascript:void(null);" class="delete_grid cmsbtnsml" id="pz_<?=$polazak['id']?>">Briši</a>
                                </td>
                            </tr>
                            <? endforeach;  ?>
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

