<? foreach($polasci as $polazak): ?>
    <tr>
        <td style="text-align: center;"><?=$polazak['id']?></td>
        <td><strong><?=$polazak['pocetnastanica'].' <br />'. $polazak['zadnjastanica']?></strong></td>                    
        <td><strong><?
            echo date('H:i',$polazak['vrijemepolaska']).' h <br />'; 

            if($polazak['vrijemedolaska'] != 0){
                echo date('H:s',$polazak['vrijemedolaska']).' h';    
            }else echo "";//" --:-- h "

            ?></strong></td>                    
        <td>
            <?
                if($polazak['dnevni'] == 1) echo 'Dnevni';
                if($polazak['vikendom'] == 1) echo 'Vikendom';
                if($polazak['sezonski'] == 1) echo ' - sezonski';
            ?>
        </td>
        <td> <?=$polazak['naziv_prevoznika']. ' ' .$polazak['grad_prevoznika']; ?> </td>    
        <td><?=date('d.m.Y',$polazak['prvipolazak']).'<br />'. date('d.m.Y',$polazak['zadnjipolazak']);?></td>                               
        <td><?=$polazak['peron'];?></td>
        <td>
            <a href="javascript:void(0)" class="stanice_tip" id="<?=$polazak['id']?>">Stanice</a>                                                                             
        </td>

        <td style="text-align: center; padding-top: 4px;" class="actiontd">
            <a href="<?=base_url();?>polazak/core/edit/<?=$polazak['id'];?>" class="cmsbtnsml" id="<?=$polazak['id']?>">Uredi</a> 
            <a href="javascript:void(null);" class="delete_grid cmsbtnsml" id="pz_<?=$polazak['id']?>">Briši</a>
        </td>
    </tr>
<? endforeach;  ?>