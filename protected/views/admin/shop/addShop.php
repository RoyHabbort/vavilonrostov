<div class="row">
    <div class="content-width page-admin">

        <div class="btn-back block-padding" onclick="history.back()">
            Назад
        </div> 

        <div class="admin-title block-padding">
            Добавление магазина
        </div>    

        <div class='admin-result-flash-place'>
                <?= admin::getresultFlash();?>
            </div>  

        <div class="admin-page-block block-padding edit-page">

            <form  action="/admin/addShop/"  method="post" name="page-edit-material" class="edit-form" enctype="multipart/form-data">

                <?php
                    $name = 'title';
                    heretic::Widget('input', array(
                        'type' => 'text',
                        'name' => $name,
                        'label' => 'Название магазина:',
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



                <?php $this->innerPage('heretic/input/input', $arguments)?>

                <button type="submit" class="btn btn-success">Сохранить</button>
                <div class="btn btn-danger" onclick="history.back()">
                    Отменить
                </div> 
            </form>

        </div>    
    </div>
</div>