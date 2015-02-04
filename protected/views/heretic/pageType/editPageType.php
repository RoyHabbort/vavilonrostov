<div class="content-width page-admin">
    
    <div class="btn-back block-padding" onclick="history.back()">
        Назад
    </div> 
    
    <div class="admin-title block-padding">
        Редактирование типа материала &laquo;<?=$arguments['result']['title'];?>&raquo;
        <div>
            <form method='post' action='/heretic/deletePageType/<?=$arguments['result']['id_page_type']?>'>
                <input type = 'hidden' name='delete' value='page_type'>
                <input type = 'hidden' name='page' value='pageType'>
                <input type = 'hidden' name='text' value='Тип материала'>
                <button type="submit" class="btn btn-red">Удалить тип материала</button>
            </form>    
        </div>    
    </div>    
    
    <div class='error-text padding-left-20'>
        <?= heretic::getFlash('error');?>
    </div>    
    
    <div class="admin-page-block block-padding edit-page">
        
        
        <form  action="/heretic/editPageType/<?=$arguments['result']['id_page_type']?>"  method="post" name="edit-form" class="edit-form" enctype="multipart/form-data">

            <?php
                $name = 'title';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Название типа материала:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php
                $name = 'type_parent_id';
                heretic::Widget('input', array(
                    'type' => 'select',
                    'name' => $name,
                    'label' => 'Родительский материал:',
                    'options' => (!empty($arguments['parent'])) ? $arguments['parent'] : '',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            
            <?php
                $name = 'default_template';
                heretic::Widget('input', array(
                    'type' => 'template',
                    'name' => $name,
                    'label' => 'Дефолтный шаблон:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php
                $name = 'main_field';
                heretic::Widget('input', array(
                    'type' => 'checkbox',
                    'name' => $name,
                    'label' => 'Отключить предустоновленные поля:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ?>
            
            
            <?php
                $name = 'sort';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Порядок сортировки:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <button type="submit" class="btn btn-green">Сохранить</button>
        </form>
        
    </div>
    
    <div class="aux-field-block block-padding">
        <h2>Дополнительные блоки</h2>
        <div class="aux-field">
            <?php if(!empty($arguments['field'])) : ?>
            <?php foreach($arguments['field'] as $key => $value) : ?>
            <div class="aux-field-one">
                <div class="aux-field-one-title">
                    <?=$value['title']?>
                    (<?=$value['type_name']?>)
                </div>   
                <div class='aux-field-btn-del'>
                    <a class='btn btn-red' href='/heretic/deleteAuxField/<?=$arguments['result']['id_page_type']?>/<?=$value['id_field']?>'>
                        Удалить
                    </a>    
                </div>    
            </div>    
            <?php endforeach;?>
            <?php endif;?>
        </div>    
        <div class="aux-field-add">
            <form method="post" name="aux-form" class="edit-form" action="/heretic/addAuxField/<?=$arguments['result']['id_page_type']?>">
                <?php
                    $name = 'field_id';
                    heretic::Widget('input', array(
                        'type' => 'select',
                        'name' => $name,
                        'label' => 'Дополнительное поле:',
                        'options' => (!empty($arguments['aux_field'])) ? $arguments['aux_field'] : '',
                        'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                        'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                    ))
                ;?>
                
                <button type="submit" class="btn btn-green">Добавить</button>
                
            </form>    
        </div>    
    </div>    
    
</div>