<div class="content-width page-admin">
    
    
    <div class="admin-title block-padding">
        <div>Редактирование фильтров изображений</div>
        <a href='/heretic/addImageFilter/' class='btn btn-green'>Добавить фильтр</a>
    </div>    
    
    <div class='success-flash padding-left-20'>
        <?= heretic::getFlash('success');?>
    </div>    
    
    <div class="admin-page-block">
    <?php if(!empty($arguments['result'])) : ?>    
        <?php foreach ($arguments['result'] as $key => $value) : ?>
            <div class="admin-page block-padding">
                <div class="page-title">
                    <?=$value['image_filter_name'];?>
                </div>
                <div class="admin-page-btn">
                    <a href="/heretic/editImageFilter/<?=$value['id_image_filter']?>" class="btn btn-blue">Редактировать</a>
                </div>    
            </div>    
        <?php endforeach;?>  
    <?php else :?>
        <div class="block-padding">
            В данный момент нет существующих фильтров
        </div>    
    <?php endif;?>    
    </div>    
</div>