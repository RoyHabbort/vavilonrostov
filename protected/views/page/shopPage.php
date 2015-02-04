
<div class="row">
    
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div> 
    
    <div class="content-width <?=$arguments['result']['link']?>-page">
    
        <div class="shop-main-content-page">
            <div class="column shop-colomn">
                
                <div class="shop-logo-line">
                    
                    <div class="shop-btn-bck">
                        <span onclick="history.back()" class="back-btn">Назад</span>
                    </div>
                    
                    <?php if(!empty($arguments['result']['category'])) : ?>
                    <div class="shop-category">
                        Категория: <?=  magazine::getCategoryName($arguments['result']['category']) ?>
                    </div>
                    <?php endif;?>
                    <div class="clearfix"></div>
                </div>
                    
                
                <div class="shop-title">
                    <h1><?=$arguments['result']['title']?></h1>
                    
                    <?php /*
                    <div class="shop-logo">
                        <?php if(!empty($arguments['result']['logotype'][0])) : ?>
                        <img src="<?=$arguments['result']['logotype'][0]['thumb_path']?>">
                        <?php endif; ?>
                    </div>
                     * 
                     */?>
                    
                    <div class="clearfix"></div>
                </div>
                
                <div class="shop-description">
                    <?=$arguments['result']['text']?>
                </div>    
                <?php if($arguments['result']['id_page'] == 146) : ?>
                    <a href='http://www.kinocharly.ru/afisha/' class='blue-lnk'>Заказать билет</a>
                <?php endif;?>
            </div>

            <div class="column contact-colomn">
                <div class="grey-block">
                    
                    <?php if(!empty($arguments['result']['photo_magazine'])) : ?>
                    <div class="shop-slider slider-clear type-slider">
                        <div class="shop-slider-initiate">
                            <?php foreach ($arguments['result']['photo_magazine'] as $key => $value) : ?>
                                <?= heretic::viewImageWhithFancy($value['medium_path'], $value['full_path'], 'group1')?>
                            <?php endforeach;?>
                        </div>    
                    </div>
                    <?php endif;?>
                    
                    <div class="shop-contact">
                        <div class="shop-contact-title">Контакты</div>
                        
                        <div class="left-contact">
                        
                            <div class="shop-on-map">
                                <div class="shop-map-icon"></div>
                                <a href="/shop/shopMap" class="shop-contact-content shop-to-map">на схеме</a>
                            </div>
                            
                            <?php if(!empty($arguments['result']['operation_time'])) : ?>
                                <div class="shop-phone">
                                    <div class="shop-clock-icon"></div>
                                    <div class="display-inline-block">
                                        <div class="label-shop">Время работы:</div>
                                        <div class="shop-contact-content"><?=$arguments['result']['operation_time']?></div>
                                    </div>
                                </div> 
                            <?php endif;?>
                        </div>    
                        
                        <div class="right-contact">
                            <?php if(!empty($arguments['result']['phone'])) : ?>
                            <div class="shop-phone">
                                <div class="shop-phone-icon"></div>
                                <div class="shop-contact-content"><?=heretic::cityPhone($arguments['result']['phone'])?></div>
                            </div>    
                            <?php endif;?>

                            <?php if(!empty($arguments['result']['email'])) : ?>
                            <div class="shop-email">
                                <div class="shop-email-icon"></div>
                                <a target="_blank" href="mailto::<?=$arguments['result']['email']?>" class="shop-contact-content"><?=$arguments['result']['email']?></a>
                            </div>    
                            <?php endif;?>

                            <?php if(!empty($arguments['result']['website'])) : ?>
                            <div class="shop-website">
                                <div class="shop-website-icon"></div>
                                <a target="_blank" href="http://<?=$arguments['result']['website']?>" class="shop-contact-content"><?=$arguments['result']['website']?></a>
                            </div>  
                            <?php endif;?>
                        </div>   
                        
                        <div class="clearfix"></div>
                        
                    </div>
                    
                    <div class="shop-map">
                        <div class="shop-map-title">
                            Расположение магазина <?php if(!empty($arguments['result']['floor'])) :?> &mdash; <?=$arguments['result']['floor']?><?php endif;?>
                        </div>
                        <div class="shop-map-small">
                            <?php heretic::Widget('shopMap', array('shop' => $arguments['result']['link']), 'shopMapSmall') ?>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <?php if(!empty($arguments['result']['category'])) : ?>
        <div class="other-similar-shop">
            
            <div class="similar-shop-title">Похожие магазины</div>
            
            <?php heretic::Widget('block', array('category' => $arguments['result']['category'], 'id_page' =>$arguments['result']['id_page']), 'similarShop')?>
        </div>   
        <?php endif;?>
        
    </div>  
    
    
</div>
  