<?php

session_start();

if(!empty($_POST['pass_for_site'])){
    
    if($_POST['pass_for_site'] == 'qwerty12+'){
        $_SESSION['site'] = 'true';
    }
    
}

if(!empty($_SESSION['site'])){
    
    //инициализация основной настройки
    include_once 'kernel/heretic.php';
    include_once 'kernel/init.php';
}else{
    include_once 'zagl.php';
}

?>

