<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= (!empty(heretic::$_config['titlePage'])) ?  heretic::$_config['titlePage'] . ' | ' : '' ;?><?= heretic::$_config['title']?></title>
        
        <?php
            foreach (heretic::$_link as $key => $value) {
                echo '<link rel="stylesheet" type="text/css" href="/'.heretic::$_path['template'].$value.'">';
            }
        ?>
        
        <link rel="stylesheet/less" type="text/css" href="/<?=heretic::$_path['template']?>less/style.less">
        
        <script type="text/javascript" src="/<?=heretic::$_path['template']?>js/jquery-1.11.1.min.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-resource.min.js"></script>
        <script src="/<?=  heretic::$_path['template']?>js/angular/app.js"></script>
        
        <!--[if lt IE 10]>
            <link rel="stylesheet" type="text/css" href="/<?=heretic::$_path['template']?>css/ie9.css">
        <![endif]-->
        
    </head>