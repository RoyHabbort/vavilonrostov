<div class="content-width page-admin">
    
    <div class="btn-back block-padding" onclick="history.back()">
        Назад
    </div> 
    
    <div class="admin-title block-padding">
        Редактирование блока &laquo;Верхнее меню&raquo;
    </div>    
    
    <div class='error-text padding-left-20'>
        <?= heretic::getFlash('error');?>
    </div>    
    
    <div class="admin-page-block block-padding edit-page">
        
        
        <form  action="/heretic/topMenu/"  method="post" name="edit-form" class="edit-form" enctype="multipart/form-data">
            
            
            <?php
                $name = 'page_type';
                heretic::Widget('input', array(
                    'type' => 'select',
                    'name' => $name,
                    'label' => 'Материалы для меню:',
                    'options' => (!empty($arguments['options'])) ? $arguments['options'] : '',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <button type="submit" class="btn btn-green">Сохранить</button>
        </form>
        
    </div>    
</div>