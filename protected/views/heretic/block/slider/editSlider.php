<div class="content-width page-admin">
    
    <div class="btn-back block-padding" onclick="history.back()">
        Назад
    </div> 
    
    <div class="admin-title block-padding">
        Редактирование слайда &laquo;<?=$arguments['result']['title'];?>&raquo;
        <div>
            <form method='post' action='/heretic/deleteSlider/<?=$arguments['result']['id_slider']?>'>
                <input type = 'hidden' name='delete' value='slider'>
                <button type="submit" class="btn btn-red">Удалить слайд</button>
            </form>    
        </div>    
    </div>    
    
    <div class='error-text padding-left-20'>
        <?= heretic::getFlash('error');?>
    </div>    
    
    <div class="admin-page-block block-padding edit-page">
        
        
        <form  action="/heretic/editSlider/<?=$arguments['result']['id_slider']?>"  method="post" name="edit-form" class="edit-form" enctype="multipart/form-data">

            <?php
                $name = 'title';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Название слайда:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <?php
                $name = 'un_text';
                heretic::Widget('input', array(
                    'type' => 'text',
                    'name' => $name,
                    'label' => 'Подзаголовок:',
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
            
            <?php
                $name = 'text';
                heretic::Widget('input', array(
                    'type' => 'textarea',
                    'name' => $name,
                    'label' => 'Текст слайда:',
                    'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                    'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
                ))
            ;?>
            
            <div class='row-admin'>
                
                <div class="errors-text">
                    <?= (!empty($arguments['errors']['image'])) ? $arguments['errors']['image'] : '';?>
                </div>
                <label>Загрузить изображение</label>
                
                <?php if((!empty($arguments['result']['image'])) && (file_exists(heretic::$_path['images'] . 'slider/' . $arguments['result']['image'])) ) : ?>
                    <div class='admin-news-image-thumb'>
                        <img src='/<?=heretic::$_path['images'] . 'slider/' . $arguments['result']['image']?>'>
                    </div> 
                <?php endif;?>
                
                <input accept="image/jpeg" type='file' class='admin-input' name='image'>
            </div>
            
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
    
</div>