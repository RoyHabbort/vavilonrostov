<div class="stock-widget">
    
    <div class="stock-all-list">
        
        <?php if(!empty($arguments['result'])) : ?>
        
            <?php foreach($arguments['result'] as $key => $value) : ?>
                <div class="stock-list-one">
                    <?php if(!empty($value['stock_photo'][0])) : ?>
                    <a href="<?=$value['link']?>" class="stock-small-img">
                        <img src="/<?=$value['stock_photo'][0]['thumb_path']?>">
                    </a>    
                    <?php endif;?>
                    
                    <a class="stock-list-title" href="<?=$value['link']?>">
                        <?=$value['title']?>
                    </a>    
                    
                    <div class="stock-list-description">
                        <?=$value['short_description']?>
                    </div> 
                    
                    
                    <?php if(!empty($value['date_start']) || !empty($value['date_end']) ) : ?>
                    <div class="stock-period">

                        <?php if(!empty($value['date_start'])) : ?>
                        <div class="stock-period-start">
                            <?= $this->converteDate($value['date_start'])?>
                        </div>    
                        <?php endif;?>

                        <?php if(!empty($value['date_start']) && !empty($value['date_end']) ) : ?>
                            &mdash;
                        <?php endif;?>

                        <?php if(!empty($value['date_end'])) : ?>
                        <div class="stock-period-end">
                            <?= $this->converteDate($value['date_end'])?>
                        </div>    
                        <?php endif;?>

                    </div>
                    <?php endif;?>
                    
                    
                    
                </div>    
            <?php endforeach;?>
        
        <?php endif;?>
        <div class="clearfix"></div>
    </div>    
    
    
</div>    