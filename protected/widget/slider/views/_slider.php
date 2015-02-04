<div class="slider-widget">
    
    <div class="index-slider-wrapper">
        <div class="next-slide">

        </div>

        <div class="prev-slide">

        </div>

        <div id="index-slider" class="index-slider">
            <?php if(!empty($arguments['result'])) : ?>
            <?php foreach ($arguments['result'] as $key => $value) : ?>

            <div class="slide slider-one" style="background: url('/<?=heretic::$_path['images'] . 'slider/' . $value['image']?>') no-repeat 0 0; background-size:cover;">
                
                <div class="slider-content">
                    <a href="/page/pagelist/<?=$value['link']?>">
                        <div class="slider-title">
                            <?=$value['title']?>
                        </div>    
                        <div class="slider-text">
                            <?=$value['text']?>
                        </div>    
                    </a>
                </div>    
                
            </div>
            <?php endforeach;?>
            <?php endif;?>
        </div>   
    </div>  
    
       
    
</div>    