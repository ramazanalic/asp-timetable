<table class="tablesorter" id="stop_stanice_tbl" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr class="header-row">
            <th width="140px">Dani polaska</th>
            <th width="20"><a href="javascript:" id="close_stop" ><img src="assets/img/backgnds/x.png" style="margin-top: 3px;" /></a></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($res as $dani_polaska): ?>
            <tr>
                <td><?=$dani_polaska['dan']?></td>
                <td>&nbsp;</td>
            </tr>

            <? endforeach;  ?>

        <tr id="lst_odd">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
