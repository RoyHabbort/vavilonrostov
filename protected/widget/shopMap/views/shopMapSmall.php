<div class="shop-map-small-widget">
    
    
    
    <div class="shop-activated-find">
        <?=$arguments['shopInfo']["shopPath"] ?>
    </div>
    
    <div class="shop-relative svg-object">
        <?php heretic::Widget('shopMap', array('floor' => $arguments['shopInfo']['floor'], 'all_shop' => $arguments['all_shop']), 'showFloor')?>
    </div>
    
</div>