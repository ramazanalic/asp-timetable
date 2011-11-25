<? foreach($polasci as $polazak): ?>
    <tr>          
        <td><?
                echo date('H:i',$polazak['vrijemepolaska']); 

        ?></td>                    
        <td><?
                if($polazak['vrijemedolaska'] != 0){
                    echo date('H:s',$polazak['vrijemedolaska']);    
                }

        ?></td> 
        <td style="font-size: 11px; font-weight: bold;">

            <?
                switch($polazak['tippolaska']){
                    case 'd': echo 'Dnevni'; break; 
                    case 'p': echo 'Periodični'; break; 
                    case 'o': echo 'Određenim danima'; break; 
                }
                echo '&nbsp;';
            ?>
            
        </td>
        <td> <?=$polazak['naziv_prevoznika']. ' ' .$polazak['grad_prevoznika']; ?> </td>                                  
        <td style="text-align: center"><?=$polazak['peron']; if($polazak['peron']=='')echo '&nbsp;'; ?></td>
        <td style="text-align: center;">
            <a href="javascript:void(0)" class="stanice_tip" id="<?=$polazak['id']?>">Stanice</a>                                                                             
        </td>
    </tr>
    <? endforeach;  ?>