<div class="inner-menu-widget">
    
    <div class="inner-menu-block">
        <?php foreach ($arguments['innerPage'] as $key => $value) : ?>
            <div class="inner-menu-one <?= ($value['link'] == $arguments['active_page']) ? 'active' : '' ;?>">
                <a href="/page/pagelist/<?=$value['link']?>"><?=$value['title']?></a>
            </div>    
        <?php endforeach;?>
    </div>    
    
</div>    