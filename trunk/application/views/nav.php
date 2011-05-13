<div id="myslidemenu" class="jqueryslidemenu">
    <ul>
        <li><a <? if($page=='prevoznik') echo'class="selected"'; ?> href="<?=base_url();?>prevoznik/core/view">Prevoznik</a>
            <ul>
                <li><a href="<?=base_url();?>prevoznik/core/add">Dodaj</a></li>
                <li><a href="<?=base_url();?>prevoznik/core/view">Pregledaj</a></li>
            </ul>
        </li>
        <li><a <? if($page=='polazak') echo'class="selected"'; ?> href="<?=base_url();?>polazak/core/view">Polasci</a>
            <ul>
                <li><a href="<?=base_url();?>polazak/core/add">Dodaj</a></li>
                <li><a href="<?=base_url();?>polazak/core/view">Pregledaj</a></li>
            </ul>
        </li>
        <li><a <? if($page=='pretrazivac') echo'class="selected"'; ?> href="parking">Pretraživač</a></li>

        <li class="no-margin"><a href="<?=base_url();?>stanica/core/view" class="no-margin <? if($page=='stanica') echo'selected"'; ?>" >Stanica</a>
            <ul>
                <li><a href="<?=base_url();?>stanica/core/add">Dodaj</a></li>
                <li><a href="<?=base_url();?>stanica/core/view">Pregledaj</a></li>
            </ul>
        </li>
    </ul>
</div>
