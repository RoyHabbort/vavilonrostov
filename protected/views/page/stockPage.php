<div class="row news-page">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
           
            <div class="work-place">
                
                <h1><?=$arguments['result']['title']?></h1>
                
                <?php if(!empty($arguments['result']["stock_photo"])) : ?>
                <div class="stock-photo">
                    
                    <?php if(count($arguments['result']["stock_photo"]) <= 1) :?>
                    
                        <div class="stock-image-one">
                            <img src="/<?=$arguments['result']["stock_photo"][0]['medium_path']?>">
                        </div>    
                    
                    <?php else : ?>
                    
                        <div class="stock-slider slider-clear type-slider">

                            <div class="stock-slider-initiate">
                                <?php foreach ($arguments['result']['stock_photo'] as $key => $value) : ?>
                                    <img src="/<?=$arguments['result']["stock_photo"][0]['medium_path']?>">
                                <?php endforeach;?>
                            </div> 
                            
                        </div>   
                    
                    <?php endif;?>
                    
                     
                </div>
                <?php endif;?>
                
                <div class="page-content">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                </div>
                
                <?php if(!empty($arguments['result']['date_start']) || !empty($arguments['result']['date_end']) ) : ?>
                <div class="stock-period">
                    
                    <?php if(!empty($arguments['result']['date_start']) && $arguments['result']['date_start'] != '0000-00-00 00:00:00') : ?>
                    <div class="stock-period-start">
                        <?= $this->converteDate($arguments['result']['date_start'])?>
                    </div>    
                    <?php endif;?>
                    
                    <?php if(!empty($arguments['result']['date_start']) 
                            && !empty($arguments['result']['date_end']) 
                            &&  $arguments['result']['date_end'] != '0000-00-00 00:00:00' 
                            && $arguments['result']['date_start'] != '0000-00-00 00:00:00') : ?>
                        &mdash;
                    <?php endif;?>
                    
                    <?php if(!empty($arguments['result']['date_end']) && $arguments['result']['date_end'] != '0000-00-00 00:00:00' ) : ?>
                    <div class="stock-period-end">
                        <?= $this->converteDate($arguments['result']['date_end'])?>
                    </div>    
                    <?php endif;?>
                
                </div>
                <?php endif;?>
                
            </div>
        </div>  
    </div>    
</div>    