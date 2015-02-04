<div class="stock-main-widget">
    
    <div class="stock-main-list slider-clear">
        
        <?php if(!empty($arguments['result'])) : ?>
        <div class="stock-main-slider">
            <?php foreach ($arguments['result'] as $key => $value) : ?>
               
                <a href="<?=$value['link']?>" class="stock-main-one">
                    <div class="stock-img-wrap">
                        <img src="/<?=$value["stock_photo"][0]['thumb_path']?>">
                    </div>  
                </a> 
            
            <?php endforeach;?>
        </div>
        <?php endif;?>
            
    </div>    
    
</div>    