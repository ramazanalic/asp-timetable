<table class="tablesorter" id="stop_stanice_tbl" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr class="header-row">
            <th width="140px">Prvi polazak</th>
            <th width="140px">Broj ponavljanja</th>
            <th width="20"><a href="javascript:" id="close_stop" ><img src="assets/img/backgnds/x.png" style="margin-top: 3px;" /></a></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($res as $polazak): ?>
            <tr>
                <td><?= date('d.m.Y',$polazak['prvipolazak'])?></td>
                <td>na <b><?=$polazak['periodicni']?></b> dana</td>
                <td>&nbsp;</td>
            </tr>

            <? endforeach;  ?>

        <tr id="lst_odd">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
