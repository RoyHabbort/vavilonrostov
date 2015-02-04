<div class="alfavit-search-widget">
    
    <div class="alfavit-search-list">
        <?php if(!empty($arguments['alfavit'])) : ?>
            <?php foreach ($arguments['alfavit'] as $key => $value) :?>
                
                <div class="alfavit-string">
                    <?php foreach ($value as $key2 => $value2) : ?>
                        <div class="alfavit-one <?= ($arguments['activeLetter'] == $value2) ? 'active' : '';?>"><?=$value2?></div>
                    <?php endforeach;?>
                </div>
        
            <?php endforeach;?>
        <?php endif;?>
        
    </div>
</div>    