<div class="content-width page-admin">
    
    <div class="btn-back block-padding" onclick="history.back()">
        Назад
    </div> 
    
    <div class="admin-title block-padding">
        Создание материала
    </div>    
    
    <div class='error-text padding-left-20'>
        <?= heretic::getFlash('error');?>
    </div>    
    
    <div class="admin-page-block block-padding edit-page">
        
        <form  action="/heretic/addPage/<?=$arguments['idPageType']?>"  method="post" name="page-edit-material" class="edit-form"  enctype="multipart/form-data">

            <?php
                $name = 'title';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Название материала:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php
                $name = 'link';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Ссылка:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php if($arguments['main_field']) : ?>
            
            <?php
                $name = 'text';
                heretic::Widget('input', array(
                    'type' => 'textarea',
                    'name' => $name,
                    'label' => 'Текст страницы:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php endif;?>
            
            <?php
                $name = 'parent_id';
                heretic::Widget('input', array(
                    'type' => 'select',
                    'name' => $name,
                    'label' => 'Родительский материал:',
                    'options' => (!empty($arguments['parent'])) ? $arguments['parent'] : '',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php if($arguments['main_field']) : ?>
            
            <?php
                $name = 'template';
                heretic::Widget('input', array(
                    'type' => 'template',
                    'name' => $name,
                    'label' => 'Шаблон:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php endif;?>
            
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
            
            
            <?php $this->innerPage('heretic/input/input', $arguments)?>

            <button type="submit" class="btn btn-green">Сохранить</button>
        </form>
        
    </div>    
</div>