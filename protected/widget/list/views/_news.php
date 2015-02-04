<div class='news-widget'>
    
    <div class='news-list'>
        <?php if(!empty($arguments['result'])) : ?>
            
            <?php foreach ($arguments['result'] as $key => $value) : ?>
                <div class='news-all-one'>
                    <div class='news-all-img-wrap'>
                        <img src="<?=$value['news_photo'][0]['thumb_path']?>">
                    </div>
                    <div class='news-body'>
                        <div class='news-title-line'>
                            <a href='/<?=$value['link']?>' class='news-title'><?=$value['title']?></a>
                            <div class='news-date'><?=$this->converteDate($value['date_create'])?></div>
                            <div class='clearfix'></div>
                        </div>
                        
                        <div class='news-short-text'><?=$this->previewText($value['text'], 500)?></div>
                    </div>
                    <div class='clearfix'></div>
                </div>    
            <?php endforeach;?>
        
        <?php endif;?>
    </div>
    
</div>