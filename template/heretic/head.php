<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ru">
    <head>
        <title><?= (!empty(heretic::$_config['titlePage'])) ?  heretic::$_config['titlePage'] . ' | ' : '' ;?><?= heretic::$_config['title']?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php
            
            foreach (heretic::$_link as $key => $value) {
                echo '<link rel="stylesheet" type="text/css" href="/'.heretic::$_path['template'].$value.'">';
            }
            
        ?>
        
        
        <link rel="stylesheet/less" type="text/css" href="/<?=heretic::$_path['template']?>less/admin.less">
        
    </head>