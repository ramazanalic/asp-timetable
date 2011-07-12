<table class="tablesorter" id="stop_stanice_tbl" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr class="header-row">
            <th width="140px">Stanica</th>
            <th width="30">Polazak</th>
            <th width="30">Dolazak</th>
            <th width="20">Km</th>
            <th width="20"><a href="javascript:" id="close_stop" ><img src="assets/img/backgnds/x.png" style="margin-top: 3px;" /></a></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($res as $st_stanica): ?>
            <tr>
                <td><?=$st_stanica['naziv_stanice']?></td>
                <td><strong>
                        <?
                            if(($st_stanica['vrijemepolaska'] != NULL) && ($st_stanica['vrijemepolaska'] != 0)) echo date('H:i',$st_stanica['vrijemepolaska']);
                        ?>
                    </strong></td>                    
                <td><strong>
                        <?
                            if(($st_stanica['vrijemedolaska'] != NULL) && ($st_stanica['vrijemedolaska'] != 0)) echo date('H:i',$st_stanica['vrijemedolaska']);
                        ?>
                    </strong></td>                    
                <td><?=$st_stanica['km']?></td>
                <td>&nbsp;</td>
            </tr>

            <? endforeach;  ?>

        <tr id="lst_odd">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
