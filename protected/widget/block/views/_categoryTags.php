<div class="category-tags-widget">
    
    <?php if(is_array($arguments['result'])) : ?>
        <div class="category-tags-list">
            <a class="category-tags-one <?=(empty($arguments['activeCategory'])) ? 'active' : '' ;?>" href="/shop">
                Все магазины
            </a>
            
        <?php foreach ($arguments['result'] as $key => $value) : ?>
            <div class="category-tags-one <?=( $arguments['activeCategory'] == $value['id_page'] ) ? 'active' : '' ;?>" data-tags="<?=$value['id_page']?>">
               <?=$value['title']?>
            </div>
        <?php endforeach;?>
            <div class="clearfix"></div>
        </div>    
    <?php endif;?>
    
    
</div>    
