<div class="content-width page-admin">
    
    <div class="btn-back block-padding" onclick="history.back()">
        Назад
    </div> 
    
    <div class="admin-title block-padding">
        Редактирование материала &laquo;<?=$arguments['result']['title'];?>&raquo;
        <div>
            <form method='post' action='/heretic/deleteField/<?=$arguments['result']['id_field']?>/'>
                <input type = 'hidden' name='delete' value='field'>
                <button type="submit" class="btn btn-red">Удалить поле</button>
            </form>    
        </div>    
    </div>    
    
    <div class='error-text padding-left-20'>
        <?= heretic::getFlash('error');?>
    </div>    
    
    <div class="admin-page-block block-padding edit-page">
        
        <div class="error-text">
            <?= (!empty($arguments['errors']['mysql_error'])) ? $arguments['errors']['mysql_error'] : '' ;?>
        </div>
        
        <form  action="/heretic/editField/<?=$arguments['result']['id_field']?>"  method="post" name="edit-form" class="edit-form" enctype="multipart/form-data">

            <?php
                $name = 'title';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Название поля:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <button type="submit" class="btn btn-green">Сохранить</button>
        </form>
        
    </div>    
</div>