<div class="row">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page">
        <div class="table-type">
            <div class="work-place">
                <h1><?=$arguments['result']['title']?></h1>
                <div class="page-content">
                    
                    <?php if(!empty($arguments['result']['slider_appartament'])) : ?>
                    <div class="appartaments-slider slider-clear">
                        <div class="appartaments-slider-main-wrap">
                            <div class="appartaments-slider-main">
                            <?php foreach ($arguments['result']['slider_appartament'] as $key => $value) : ?>
                                <div class="slide">
                                    <img src="/<?=$value['medium_path']?>">
                                </div>    
                            <?php endforeach;?>   
                            </div>
                        </div>
                            
                        <div class="appartaments-slider-thumb-wrap">
                            <div class="appartaments-slider-thumb">
                            <?php foreach ($arguments['result']['slider_appartament'] as $key => $value) : ?>
                                <a data-slide-index="<?=$key?>" href=""  class="slide slide-thumb">
                                    <div class="slide-img">
                                        <img src="/<?=$value['thumb_path']?>">
                                        <div class="shadow-img"></div>
                                    </div>    
                                </a>
                            <?php endforeach;?>
                            </div>    
                        </div>  
                            
                    </div>    
                    <?php endif;?>
                    
                    <?php if(!empty($arguments['result']['price_appartament'])) : ?>
                    <div class="price_appartament">
                        Цена: <?= $this->smarty_modifier_sum_convert($arguments['result']['price_appartament'], 'summaDay')?>
                    </div>    
                    <?php endif;?>
                    
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                    
                </div>
            </div>
        </div>    
    </div>    
</div>    