<div class="news-widget">
    
    <a href='/news' class='type-2-lnk'><h2>Новости и события</h2></a>
    <div class="news-widget-lint slider-clear">
        <?php if(!empty($arguments['result'])) : ?>
        <div class="news-slider">
            
            <?php foreach($arguments['result'] as $key => $value) :?>
            <div class="news-one slide">
                
                <a href="/<?=$value['link']?>" class="news-img-wrap">
                    <img src="/<?=$value['news_photo'][0]['thumb_path']?>">
                </a>    
                
                <div class="news-one-date">
                    <span class='b-date'><?=$this->converteDate($value['date_create'], 'onlyDay')?></span>
                    <span><?=$this->converteDate($value['date_create'], 'onlyMonth')?></span>
                </div>
                
                <a href="/<?=$value['link']?>" class="news-one-title"><?=$value['title']?></a>
                
                <div class="news-text">
                    <?= $this->smarty_modifier_truncate($value['short_description'], 75)?>
                </div>
            </div>  
            <?php endforeach; ?>

        </div>    
        <?php endif; ?>    
        
    </div>    
    
</div>    