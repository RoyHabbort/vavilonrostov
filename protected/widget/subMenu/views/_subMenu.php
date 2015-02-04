<div class="sub-menu-widget">
    
    <div class="sub-menu-list">
        
        <div class="sub-menu-first">
            <span>Специальные предложения и выгодные условия проживания в отеле</span>
        </div>    
        
        <?php if(!empty($arguments['result'])) : ?>
            <?php foreach ($arguments['result'] as $key => $value) : ?>

            <div class="sub-menu-one">
                <span class="sub-menu-one-icon"></span>
                <span><?=$value?></span>
            </div>    

            <?php endforeach;?>
        <?php endif;?>
        
    </div>    
    
</div>    