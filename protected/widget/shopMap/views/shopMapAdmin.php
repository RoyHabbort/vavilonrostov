
<div class="shop-map-widget">
    
    <div class="left-shop-map">
        <div class="shop-map-menu">

            <div class="shop-map-menu-one" data-floor="4">
                4 этаж
            </div>
            <div class="shop-map-menu-one" data-floor="3">
                3 этаж
            </div>
            <div class="shop-map-menu-one" data-floor="25">
                2,5 этаж
            </div>
            <div class="shop-map-menu-one" data-floor="2">
                2 этаж
            </div>
            <div class="shop-map-menu-one" data-floor="15">
                1,5 этаж
            </div>
            <div class="shop-map-menu-one active" data-floor="1">
                1 этаж
            </div>
            <div class="shop-map-menu-one" data-floor="0">
                Цокольный этаж
            </div>
            
        </div>
           
        
    </div>
    
    
    
    <div class="full-map-wrap svg-object">
        <div class="0-floor floor-wrap ">
            <?php heretic::Widget('shopMap', array('floor' => '0', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
        <div class="1-floor floor-wrap active">
            <?php heretic::Widget('shopMap', array('floor' => '1', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
        <div class="15-floor floor-wrap">
            <?php heretic::Widget('shopMap', array('floor' => '15', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
        <div class="2-floor floor-wrap">
            <?php heretic::Widget('shopMap', array('floor' => '2', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
        <div class="25-floor floor-wrap">
            <?php heretic::Widget('shopMap', array('floor' => '25', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
        <div class="3-floor floor-wrap">
            <?php heretic::Widget('shopMap', array('floor' => '3', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
        <div class="4-floor floor-wrap">
            <?php heretic::Widget('shopMap', array('floor' => '4', 'all_shop' => $arguments['all_shop']), 'showFloor')?>
        </div>
    </div>
    
    
    <div class="clearfix"></div>
    
</div>    