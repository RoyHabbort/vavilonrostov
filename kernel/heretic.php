<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of heretic
 *
 * @author Рой
 */
class heretic {
    
    public static $_path = array();
    public static $_config = array();
    public static $_script = array();
    public static $_link = array();
    public static $_kernel = array();
    public static $_widget = array();
    public static $_hereticMenu = array();
    public static $active_page;


    /*
     * 08-2014
     * Подключение модулей
     * Roy
     */
    
    public static function connect($path, $condition){
    
        $dir = $path;
        if(is_dir($dir)) {

            $files = scandir($dir);

            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            foreach ($files as $key => $value) {
                if (substr_count($value, $condition)) include_once $dir . $value;
            }
        }
        
    }
    
    public static function connectDir($dir, $array, $condition){
        
        if(is_dir($dir)) {
            
            foreach ($array as $key => $value) {
                include_once $dir . $value . $condition;
            }
            
        }
        
    }
    
    /*------------------------------------------------------------------------*/
    
    
    /*
     * 08-2014
     * Вызов виджета
     * Roy
     */
    
    public static function Widget($name, $arguments = array(), $method = 'index'){

            $file = heretic::$_path['widget'] . $name . '/' . $name . 'Widget.php';
            $class = $name . 'Widget'; 
            if (!is_readable($file)){
                return false;
            }else{
                
                if(!in_array($class, heretic::$_widget)){
                    include $file;
                    heretic::$_widget[] = $class;
                }
                $widget = new $class;
                $widget->$method($arguments);
                return true;
            }
      }
      
      /*----------------------------------------------------------------------*/
      
      
      /*
       * 08-2014
       * Не помню что за функция
       * Roy
       */
      
      public static function cout($params){
          if(!empty($params)) return $params;
            else return NULL;
      }
      
      /*----------------------------------------------------------------------*/
      
      /*
       * 08-2014
       * Работа с подсказками
       * roy
       */
      
      public static function setFlash($name, $value){
          $_SESSION[$name] = $value;
      }
      
      public static function getFlash($name){
          if (!empty($_SESSION[$name])) {
              $return = $_SESSION[$name];
              heretic::destroyFlash($name);
              return $return;
          } else return NULL;
      }
      
      public static function destroyFlash($name){
          if (!empty($_SESSION[$name])) unset($_SESSION[$name]);
      }
    
      /*----------------------------------------------------------------------*/
      
    
    /*
     * 10-2014
     * Организация редиректа с подсказками
     * roy
     */  
      
    public static function redirect($action, $address, $text){
        heretic::setFlash ($action, $text);
        $location = $address;
        header( "Location: {$location}", true, 303 );
    }
    
    
    /*
     * 14-10-2014
     * Структурированный вывод массивов
     * roy
     */
    
    public static function hvar_dump($array){
        echo "<div class='dubug-wrap'><pre>";
        var_dump($array);
        echo "</pre></div>";
    }
      
    
    /*
     * 29-10-2014
     * Ввод тайтла
     * roy
     */
    
    public static function setTitle($title){
        heretic::$_config['title'] = heretic::$_config['title'] . ' - ' . $title;
    }
    
    /*
     * 8-12-2014
     * Перевод в транслит
     * roy
     */
    
    public static function translitString($str){
        $translit = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"," "=>"_"
        );
        return strtr($str,$translit);
        return $str;
    }
    
    
    /*
     * 11-12-2014
     * Добавление изображения с заглушкой
     * roy
     */
    
    public static function viewImage($link){
        
        heretic::hvar_dump($link);
        
        if(file_exists($link)){
            return "<img src='/{$link}'>";
        }else{
            $link2 = '/' . $link;
            if(file_exists($link2)){
                return "<img src='/{$link2}'>";
            }
            
        }
        if(file_exists(heretic::$_config['notImage'])){
            return "<img src='/" . heretic::$_config['notImage'] . "' alt='Изображение отсутствует'>";
        }
        
        if(file_exists('template/error/img/not_photo.jpg')){
            return "<img src='/template/error/img/not_photo.jpg' alt='Изображение отсутствует'>";
        }
        
    }
    
    
    
    /*
     * 12-01-2015
     * Добавление изображения с заглушкой и фансибоксом
     * roy
     */
    
    public static function viewImageWhithFancy($link, $linkFull, $group){
        
        if(file_exists($link)){
            return "<a rel='{$group}' class='fancybox' href='/{$linkFull}'><img src='/{$link}'></a>";
        }else{
            $link2 = '/' . $link;
            if(file_exists($link2)){
                return "<a rel='{$group}' class='fancybox' href='/{$linkFull}'><img class='fancybox' src='/{$link2}'></a>";
            }
            
        }
        if(file_exists(heretic::$_config['notImage'])){
            return "<img src='/" . heretic::$_config['notImage'] . "' alt='Изображение отсутствует'>";
        }
        
        if(file_exists('template/error/img/not_photo.jpg')){
            return "<img src='/template/error/img/not_photo.jpg' alt='Изображение отсутствует'>";
        }
        
    }
    
    /*
     * 16-01-2015
     * Вывод телефона
     * roy
     */
    
    public static function cityPhone($phone){
        
        $result = substr($phone, 3, 15);
        
        return $result;
        
    }
    
    
}
