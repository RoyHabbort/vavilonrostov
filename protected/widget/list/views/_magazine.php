<div class="magazine-list-widget">
    
   
<?php if($arguments['result']) :?>
    <div class="magazine-block-list"> 
    <?php foreach ($arguments['result'] as $key => $value) : ?>
        <div  class="magazine-one">
            
            <div class="magazine-one-logo">
                <div class="magazine-one-logo-div">
                    
                    <?php if(!empty($value['logotype'][0])) : ?>
                        <img src="<?=$value['logotype'][0]['thumb_path']?>">
                    <?php else : ?>
                        <?=mb_substr($value['title'], 0, 1, "UTF-8")?>
                    <?php endif; ?>
                    
                    
                </div>    
            </div>    
            
            <div class="magazine-one-title">
                <a href="/<?=$value['link']?>" class="magazine-one-title-div">
                    <?=$value['title']?>
                </a>    
                <div class="magazine-one-short-description">
                    <?=$value['short_description']?>
                </div>
            </div>    
            
            <div class="magazine-one-phone">
                <?php if(!empty($value['phone'])) : ?>
                <div class="magazine-one-line">
                    <div class="shop-phone-icon"></div>
                    <div class="shop-contact-content">
                        <?=heretic::cityPhone($value['phone'])?>
                    </div>    
                </div>    
                <?php endif;?>
            </div>    
            
            <div class="magazine-one-floor">
                <?php if(!empty($value['floor'])) : ?>
                <div class="magazine-one-line">
                    <div class="shop-floor-icon"></div>
                    <div class="shop-contact-content">
                        <?=$value['floor']?>
                    </div>
                </div>    
                <?php endif;?>
            </div>
            
            <div class="magazine-one-web">
                <?php if(!empty($value['website'])) : ?>
                <div class="magazine-one-line">
                    <div class="shop-website-icon"></div>
                    <a class="magazine-website shop-contact-content" target="_blick" href="http://<?=$value['website']?>">
                        <?=$value['website']?>
                    </a> 
                </div> 
                <?php endif;?>
            </div>
            
        </div>
    <?php endforeach;?>
    </div>    
<?php else : ?>
    <div>По данному запросу ничего не найдено</div>
<?php endif; ?>
</div>