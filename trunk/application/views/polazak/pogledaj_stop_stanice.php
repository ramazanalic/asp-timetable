<table class="tablesorter" id="stop_stanice_tbl" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr class="header-row">
            <th>STANICA</th>
            <th>VRIJEME POLASKA</th>
            <th>VRIJEME DOLASKA</th>
            <th>KM</th>
        </tr>
    </thead>
    <tbody>
        <? foreach($res as $st_stanica): ?>
            <tr>
                <td><?=$st_stanica['naziv_stanice']?></td>
                <td><strong>
                <?
                    if($st_stanica['vrijemepolaska'] != NULL) echo date('H:i',$st_stanica['vrijemepolaska']).' h';
                ?>
                </strong></td>                    
                <td><strong>
                <?
                    if($st_stanica['vrijemedolaska'] != NULL) echo date('H:i',$st_stanica['vrijemedolaska']).' h';
                ?>
                </strong></td>                    
                <td><?=$st_stanica['km']?></td>
            </tr>
            <? endforeach;  ?>
    </tbody>
</table>