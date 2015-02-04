<div class="content-width page-admin">
    
    
    <div class="admin-title block-padding">
        <div>Редактирование дополнительных полей</div>
        <a href='/heretic/addField/' class='btn btn-green'>Добавить поле</a>
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
                    <a href="/heretic/editField/<?=$value['id_field']?>" class="btn btn-blue">Редактировать</a>
                </div>    
            </div>    
        <?php endforeach;?>  
    <?php else :?>
        <div class="block-padding">
            В данный момент нет существующих дополнительных полей
        </div>    
    <?php endif;?>    
    </div>    
</div>