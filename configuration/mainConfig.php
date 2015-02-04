<?php

heretic::$_config = array(
    'db' => array(
        'db_host' => "localhost",
        'db_login' => "vavilonrostov",
        'db_password' => "dfgoj4r7hsd7hff",
        'db_name' => "vavilonrostov"
    ),
    'host_name' => $_SERVER["HTTP_HOST"],
    'debug' => TRUE,
    'main_page' => '/',
    'template_name' => 'vavilon',
    'default_controller' => 'page',
    'extension' => array(
        'phoneMask' => array(
            'name' => 'phoneMask',
            'description' => 'Маска ввода телефона',
            'dir' => 'phoneMask/',
            'template' => 'all',
            'js' => array(
                'phoneMask' => 'phoneMask.js'
            ),
            'css' => array(
                
            )
        ),
        'ckeditor' => array(
            'name' => 'ckEditor',
            'description' => 'Редактор текстовой формы',
            'dir' => 'ckeditor/',
            'template' => 'admin',
            'js' => array(
                'ckeditor' => 'ckeditor.js'
            ),
            'css' => array(
                
            )
        ),
        'bxslider' => array(
            'name' => 'bxslider',
            'description' => 'Фото-слайдер',
            'dir' => 'bxslider/',
            'template' => 'all',
            'js' => array(
                'bxslider' => 'jquery.bxslider.min.js',
            ),
            'css' => array(
                'bxslider' => 'jquery.bxslider.css',
            )
        ),
        'jquery_upload' => array(
            'name' => 'upload',
            'description' => 'Загрузка изображений',
            'dir' => 'jquery_uploadfile/',
            'template' => 'admin',
            'js' => array(
                'jquery_upload' => 'js/jquery.uploadfile.js',
            ),
            'css' => array(
                
            )
        ),
        'checkbox' => array(
            'name' => 'icheck',
            'description' => 'Стилизация чекбоксов',
            'dir' => 'checkbox/',
            'template' => 'admin',
            'js' => array(
                'checkbox' => 'icheck.min.js'
            ),
            'css' => array(
                'checkbox' => 'square/blue.css'
            )
        ),
        'fancyBox' => array(
            'name' => 'fancyapps-fancyBox',
            'description' => 'фансибокс',
            'template' => 'all',
            'dir' => 'fancyapps-fancyBox/',
            'js' => array(
                'fancybox' => 'source/jquery.fancybox.js',
            ),
            'css' => array(
                'fancybox' => 'source/jquery.fancybox.css',
            )
        ),
    ),
    'title' => 'ТРЦ Вавилон',
    'titlePage' => '',
    'extend_config' => array(
        
        ),
    'mail'=> array(
        'email' => 'resq7@mail.ru',
        'name' => 'ТРЦ Вавилон',
    ),
    'admin_page' => array(array('index', 'name', 'link')),
    'notImage' => 'template/vavilon/img/error/not_photo_870.jpg'
    
);