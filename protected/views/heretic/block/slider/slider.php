<div class="content-width page-admin">
    
    
    <div class="admin-title block-padding">
        <div>Редактирование слайдов</div>
        <a href='/heretic/addSlider/' class='btn btn-green'>Добавить слайд</a>
    </div>    
    
    <div class='success-flash padding-left-20'>
        <?= heretic::getFlash('success');?>
    </div>    
    
    <div class="admin-page-block">
    <?php if(!empty($arguments['result'])) : ?>    
        <?php foreach ($arguments['result'] as $key => $value) : ?>
            <div class="admin-page block-padding">
                <div class="page-title">
                    <?=$value['title'];?>
                </div>
                <div class="admin-page-btn">
                    <a href="/heretic/editSlider/<?=$value['id_slider']?>" class="btn btn-blue">Редактировать</a>
                </div>    
            </div>    
        <?php endforeach;?>  
    <?php else :?>
        <div class="block-padding">
            В данный момент нет существующих типов материалов
        </div>    
    <?php endif;?>    
    </div>    
</div>