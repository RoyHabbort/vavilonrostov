<div class='menu-shop-widget'>
    
    <div class='shop-menu-list'>
        
        <?php if(!empty($arguments['result'])) : ?>
        <?php foreach ($arguments['result'] as $key => $value) : ?>
        <div class='shop-menu-one'>
            <div class="table-style">
                <a href='/shop&category=<?=$value['id_page']?>&letter='><?=$value['title']?></a>
                <div class="shop-count-cell">
                    <span class='shop-count'><?=$value['count_shop']?></span>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <?php endif;?>
        
        <div class='shop-menu-one'>
            <div class="table-style" data-click="otherMenu()">
                <span class="span-a">Другие</span>
                <div class="shop-count-cell">
                    <span class='shop-count'>6</span>
                </div>
            </div>
        </div>
        
        <div class="other-menu">
            
            <?php if(!empty($arguments['other'])) :?>
            <?php foreach($arguments['other'] as $key => $value) :?>
            
            <div class='shop-menu-one'>
                <div class="table-style" data-click="otherMenu()">
                    <a href='/shop&category=<?=$value['id_page']?>&letter='><?=$value['title']?></a>
                    <div class="shop-count-cell">
                        <span class='shop-count'><?=$value['count_shop']?></span>
                    </div>
                </div>
            </div>
            
            <?php endforeach;?>
            <?php endif;?>
            
        </div>    
        
        
    </div>    
    
</div>    