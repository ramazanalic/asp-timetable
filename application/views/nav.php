<div id="myslidemenu" class="jqueryslidemenu">
    <ul>
        <li><a href="<?=base_url();?>prevoznik/core/view">Prevoznik</a>
            <ul>
                <li><a href="<?=base_url();?>prevoznik/core/add">Dodaj</a></li>
                <li><a href="<?=base_url();?>prevoznik/core/view">Pregledaj</a></li>
            </ul>
        </li>
        <li><a href="<?=base_url();?>ruta/core/index/view">Ruta</a>
            <ul>
                <li><a href="<?=base_url();?>ruta/core/add">Dodaj</a></li>
                <li><a href="<?=base_url();?>ruta/core/view">Pregledaj</a></li>
            </ul>
        </li>
        <li><a <? if($page=='services') echo'class="selected"'; ?> href="services">Polazak</a>
            <ul>
                <li><a href="#">Dodaj</a></li>
                <li><a href="#">Pregledaj</a></li>
            </ul>
        </li>
        <li><a <? if($page=='parking') echo'class="selected"'; ?> href="parking">Pretraživač</a></li>
        <li class="no-margin"><a href="news" class="no-margin" <? if($page=='news') echo'class="selected"'; ?>>Stop stanica</a>
            <ul>
                <li><a href="#">Dodaj</a></li>
                <li><a href="#">Pregledaj</a></li>
            </ul>
        </li>
    </ul>
</div>
