<div class="row news-page">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
           
            <div class="work-place content-width">
                
                <h1><?=$arguments['result']['title']?></h1>
                
                
                
                <?php if(!empty($arguments['result']["news_photo"])) : ?>
                <div class="news-photo">
                    
                    <?php if(count($arguments['result']["news_photo"]) <= 1) :?>
                    
                        <div class="news-image-one">
                            <img src="/<?=$arguments['result']["news_photo"][0]['medium_path']?>">
                        </div>    
                    
                    <?php else : ?>
                    
                        <div class="news-slider slider-clear type-slider">

                            <div class="news-slider-initiate">
                                <?php foreach ($arguments['result']['news_photo'] as $key => $value) : ?>
                                    <img src="/<?=$arguments['result']["news_photo"][0]['medium_path']?>">
                                <?php endforeach;?>
                            </div> 
                            
                        </div>   
                    
                    <?php endif;?>
                    
                     
                </div>
                <?php endif;?>
                
                <div class="date-news"><?=$this->converteDate($arguments['result']['date_create']);?></div>
                
                <div class="page-content">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                </div>
             
                
            </div>
        </div>  
    </div>    
</div>    