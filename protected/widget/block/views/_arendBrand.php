<div class="arend-brand-widget">
    
    <div class='arend-options-title-h'>Якорные арендаторы</div>
    
    <div class="arend-brand-list">
        <?php if(!empty($arguments['result'])) : ?>
        
            <?php foreach($arguments['result'] as $key => $value) : ?>
                <a href='<?=$value['link']?>' class="arend-brand-one">
                    <img src="<?=$value['logotype'][0]['medium_path']?>">
                </a>    
            <?php endforeach;?>
        
        <?php endif;?>
    </div>    
    
</div>    