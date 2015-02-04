<div class="inner-menu-widget">
    
    <div class="standart-menu-block">
        <?php if(!empty($arguments['result'])) :?>
            <?php foreach ($arguments['result'] as $key => $value) : ?>
                <div class="inner-menu-one <?= ($value['link'] == $arguments['active_page']) ? 'active' : '' ;?>">
                    <a href="/<?=$value['link']?>"><?=$value['title']?></a>
                </div>
            <?php endforeach;?>
        <?php endif; ?>
    </div>    
</div>    