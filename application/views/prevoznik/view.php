
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Pregled prevoznika</div>
            <div class="cnt_cnt">
                <div id="infomessage" style="display: none;"></div>
                <table class="tablesorter" id="carviews" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="30" style="text-align: center;">ID</th>
                            <th>Naziv</th>
                            <th>Opis</th>
                            <th width="220" style="text-align: center;">Akcija</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($prevoznici as $prevoznik): ?>
                            <tr>
                                <td style="text-align: center;"><?=$prevoznik['id']?></td>
                                <td  class="exc_title"><strong><?=$prevoznik['naziv'].' '.$prevoznik['grad']?></strong></td>                    
                                <td  class="exc_title"><?=$prevoznik['opis']?></td>                    

                                <td style="text-align: center; padding-top: 4px;" class="actiontd">
                                    <a href="<?=base_url();?>prevoznik/core/edit/'.<?=$prevoznik['id'];?>" class="edit_grid" id="<?=$prevoznik['id']?>">Uredi</a> 
                                    <a href="javascript:void(null);" class="delete_grid" id="ex_<?=$prevoznik['id']?>">Brisi</a>
                                </td>
                            </tr>
                            <? endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>