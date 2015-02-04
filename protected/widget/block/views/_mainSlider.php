<div class='main-slider-widget'>
    
    <div class='main-slider slider-clear'>
        <?php if(!empty($arguments['result'])) : ?>
        <div class='main-slider-list'>
            
            <?php foreach($arguments['result'] as $key => $value) : ?>
            
            <div class='main-slider-one'>
                <a href="<?=$value['link_promo']?>" class='main-slider-img'>
                    <img src='/<?=$value['promo_banner'][0]['medium_path']?>'>
                </a>
            </div>
            
            <?php endforeach;?>
        </div>    
        <?php endif; ?>
    </div>    
    
</div>    