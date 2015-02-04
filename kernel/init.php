<?php

header('Content-Type: text/html; charset=utf8');

//Подключение дополнений
include_once 'additions/PHPMailer/class.phpmailer.php';
include_once 'additions/phpExcel/PHPExcel.php';
include_once 'additions/phpExcel/PHPExcel/IOFactory.php';

//Подключение классов
heretic::connect('configuration/', 'Config.php');
heretic::connectDir('class/', heretic::$_kernel, 'Class.php');
heretic::connect(heretic::$_path['models'], '.php');


$database = new databaseClass();
$database ->selectDatabase(heretic::$_config['db']);



$router = new routerClass();
$router->delegate();

?>

