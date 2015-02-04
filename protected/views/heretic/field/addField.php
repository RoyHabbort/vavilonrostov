<div class="content-width page-admin">
    
    <div class="btn-back block-padding" onclick="history.back()">
        Назад
    </div> 
    
    <div class="admin-title block-padding">
        Создание поля
    </div>    
    
    <div class='error-text padding-left-20'>
        <?= heretic::getFlash('error');?>
    </div>    
    
    <div class="admin-page-block block-padding edit-page">
        
        <div class="error-text">
            <?= (!empty($arguments['errors']['mysql_error'])) ? $arguments['errors']['mysql_error'] : '' ;?>
        </div>
        
        <form  action="/heretic/addField/"  method="post" name="edit-form" class="edit-form">

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
            
            <?php
                $name = 'field_name';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Системное имя:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            
            <?php
                $name = 'field_type_id';
                heretic::Widget('input', array(
                    'type' => 'select',
                    'name' => $name,
                    'label' => 'Тип поля:',
                    'options' => (!empty($arguments['field_type'])) ? $arguments['field_type'] : '',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
              
            <div class="section-image-filter">
            
            <?php
                $name = 'image_filter';
                heretic::Widget('input', array(
                    'type' => 'select',
                    'name' => $name,
                    'label' => 'Фильтр для изображений:',
                    'options' => (!empty($arguments['image_filter'])) ? $arguments['image_filter'] : '',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ));
            ?>
            </div>    

            <div class="section-selecter-filter">
                
                <?php
                    $name = 'selecter-filter';
                    heretic::Widget('input', array(
                        'type' => 'select',
                        'name' => $name,
                        'label' => 'Выбор из метериалов:',
                        'options' => (!empty($arguments['page_type'])) ? $arguments['page_type'] : '',
                        'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                        'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                    ));
                ?>
                
                <?php
                    $name = 'selecter_list';
                    heretic::Widget('input', array(
                        'type' => 'text',
                        'name' => $name,
                        'label' => 'Перечисление:',
                        'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                        'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                    ))
                ;?>
                
            </div>    
            
            <button type="submit" class="btn btn-green">Сохранить</button>
        </form>
        
    </div>    
</div>