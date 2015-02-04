<div class="edit-image-widget">
    <div class="edit-image-title">Загруженные изображения</div>
    <div class="image-block">
        <?php if(!empty($arguments['image']['result'])) : ?>
        <?php foreach ($arguments['image']['result'] as $key => $value) :?>
            
            <div class="edit-image-one">
                <div class="edit-image-wrap">
                    <img src="/<?=$value['path']?>" alt="<?=$value['content']?>">
                </div>    
                <div class="img-close" data-del="<?=$value['id']?>" data-field="<?=$arguments['image']['option']['field_name']?>">
                    <img src="/<?=  heretic::$_path['template']?>img/icons/icon-close.png" alt="удалить изображение <?=$value['content']?>">
                </div>    
            </div>    
        <?php endforeach;?>
        <?php endif;?>
    </div>    
</div>    