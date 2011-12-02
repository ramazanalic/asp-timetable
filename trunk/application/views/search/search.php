<? foreach($polasci as $polazak): ?>
    <tr>          
        <td><?
                //echo $polazna_vrijeme;
                echo date('H:i', $polazna_vrijeme); 

        ?></td>                    
        <td><?
                //echo $dolazna_vrijeme;
                echo date('H:i', $dolazna_vrijeme);               

        ?></td> 
        <!-- <td>
        <?
            $tip_polaska ='';
            switch($polazak['tippolaska']){
                case 'd': $tip_polaska = 'Dnevni'; break; 
                case 'p': $tip_polaska = 'Periodični'; break; 
                case 'o': $tip_polaska = 'Određenim danima'; break; 
            }

        ?>

        <a href="javascript:" style="color: #A55129; font-weight: bold; font-size: 11px; text-decoration: none;" class="polazak_tip" id="<?=$polazak['id'].'-'.$polazak['tippolaska']?>">
        <?=$tip_polaska.'&nbsp;'; ?>
        </a>

        </td> -->
        <td> <?=$polazak['naziv_prevoznika']; ?> </td>                                  
        <td style="text-align: center;">
            <a href="javascript:void(0)" class="stanice_tip" id="<?=$polazak['id']?>">Stanice</a>                                                                             
        </td>
    </tr>
    <? endforeach;  ?>