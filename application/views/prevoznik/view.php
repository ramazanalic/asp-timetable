
<div class="box">
    <div class="clearfix">
        <div class="cnt-inner">                        
            <div class="cnt_ttl">Pregled prevoznika</div>
            <div class="cnt_cnt main-table-style">
                <div id="infomessage" style="display: none;"></div>
                <table class="tablesorter" id="prevoznik_tbl" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr class="header-row">
                            <th width="30" style="text-align: center;">ID</th>
                            <th>Naziv</th>
                            <th>Opis</th>
                            <th width="120" style="text-align: center;">Akcija</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($prevoznici as $prevoznik): ?>
                            <tr>
                                <td style="text-align: center;"><?=$prevoznik['id']?></td>
                                <td  class="exc_title"><strong><?=$prevoznik['naziv'].' '.$prevoznik['grad']?></strong></td>                    
                                <td  class="exc_title"><?=$prevoznik['opis']?></td>                    

                                <td style="text-align: center; padding-top: 4px;" class="actiontd">
                                    <a href="<?=base_url();?>prevoznik/core/edit/<?=$prevoznik['id'];?>" class="edit_grid cmsbtnsml" id="<?=$prevoznik['id']?>">Uredi</a> 
                                    <a href="javascript:void(null);" class="delete_grid cmsbtnsml" id="<?=$prevoznik['id']?>">Briši</a>
                                </td>
                            </tr>
                            <? endforeach;  ?>
                    </tbody>
                </table>
                <div id="prevoznik_pgr" class="pager">
                    <div style="float: left; width: 280px; padding-left: 10px;">Ukupno <b><span class="tbl_total"></span></b> &nbsp;prevoznika</div>
                    <div class="clear-fix" style="float: left; width: 230px;">
                        <div style="float: left; height: 29px; line-height: 29px; padding-right: 5px;">
                            Rezultati po strani:</div>
                        <div class="stylish-select-container" style="float: left; line-height: 16px; padding-top: 4px;">
                            <select style="float: left;" class="pagesize">
                                <option value="5" selected="selected">5</option><option value="10">10</option><option value="20">20</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear-fix" style="float: left; width: 260px;">
                        <div style="float: right; padding-top: 6px;">
                            <div title="Last" class="myr-sprite myr-last-arrow last" style="float: left;">
                            </div>
                        </div>
                        <div style="float: right; padding-top: 6px; padding-right: 5px;">
                            <div title="Next" class="myr-sprite myr-forward-arrow next" style="float: left;">
                            </div>
                        </div>
                        
                        <div style="float: right;">
                            <span style="padding-right: 2px; font-weight: bold;" class="pagedisplay"></span>
                            <input type="text" class="pagedisplay"/>
                        </div>
                        <div style="float: right; padding-top: 6px; padding-right: 5px;">
                            <div title="Previous" class="myr-sprite myr-back-arrow prev" style="float: left;">
                            </div>
                        </div>
                        <div style="float: right; padding-top: 6px; padding-right: 5px;">
                            <div title="First" class="myr-sprite myr-first-arrow first" style="float: left;">
                            </div>
                        </div>
                    </div>
                </div>
                <i>* Prevoznici su sortirani po nazivu.</i>
            </div>
        </div>
    </div>
</div>
<script>
    var rowCount = $('#prevoznik_tbl tr').length;
    $("#prevoznik_tbl").tablesorter({
        // pass the headers argument and assing a object
        headers: {
            2: {
                sorter: false
            },
            3: {
                sorter: false
            }
        },
        widthFixed: false,
        widgets: ['zebra']
    }).tablesorterPager({
        container: $("#prevoznik_pgr"),
        size: 5,
        seperator: ' / ',
        positionFixed: false
    }); 
    
    $('.tbl_total').html(rowCount);

</script>