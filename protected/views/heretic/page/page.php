<div class="content-width page-admin">
    
    
    <div class="admin-title block-padding">
        <div>Редактирование материалов</div>
    </div>    
    
    <div class='success-flash padding-left-20'>
        <?= heretic::getFlash('success');?>
    </div>    
    
    <div class="admin-page-block">
    <?php if(!empty($arguments['result'])) : ?>    
        <?php foreach ($arguments['result'] as $key => $value) : ?>
        <div class="page-list">
            <div class="admin-page block-padding ">
                <div class="page-title bold-title page-list-btn">
                    <?=$value['title'];?>
                </div>
                <div class='btn-add-page'>
                    <a href='/heretic/addPage/<?=$value['id_page_type']?>' class='btn btn-green'>Добавить материал</a>  
                </div>
            </div>
            <div class='admin-inner-page-edit page-list-container'>
                <?php if(!empty($value['page'])) : ?>
                <?php foreach($value['page'] as $key2 => $value2) : ?>
                    <div class='admin-edit-row'>
                        <div class='admin-edit-row-title'>
                            <?=$value2['title']?> <?php if (!empty($value2['parent'])) :?>( <?=$value2['parent'];?>)<?php endif;?>
                        </div>    
                        <div class='btn-add-material'>
                            <a href='/heretic/editPage/<?=$value2['id_page']?>/<?=$value['id_page_type']?>' class='btn btn-blue'>Редактировать</a> 
                        </div>
                    </div>
                <?php endforeach;?>
                <?php endif;?>
            </div>    
        </div>     
        <?php endforeach;?>
    <?php else :?>
        <div class="block-padding">
            В данный момент нет существующих материалов
        </div>    
    <?php endif;?>    
    </div>    
</div>