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
        <td>
        
            <?
                if($polazak['dnevni'] == 1) echo 'Dnevni';
                if($polazak['vikendom'] == 1) echo 'Vikendom';
                if($polazak['sezonski'] == 1) echo ' - sezonski';
                echo '&nbsp;';
            ?>
        </td>
        <td> <?=$polazak['naziv_prevoznika']. ' ' .$polazak['grad_prevoznika']; ?> </td>                                  
        <td><?=$polazak['peron']; if($polazak['peron']=='')echo '&nbsp;'; ?></td>
        <td style="text-align: center;">
            <a href="javascript:void(0)" class="stanice_tip" id="<?=$polazak['id']?>">Stanice</a>                                                                             
        </td>
    </tr>
<? endforeach;  ?>