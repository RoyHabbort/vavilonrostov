
<div class="pagin-magaz">
    <ul>
        
        
        <?php for ($i=$arguments['pag_to']['start']; $i<=$arguments['pag_to']['end']; $i++) : ?>
        <li class='<?= ($arguments['page'] == $i) ? 'active' : '';?>'>
            <span class="page-pagination-link" data-page="<?=$i?>"> <?=$i?></span>
        </li>
        <?php endfor;?>
        
        
        
    </ul>
</div>    