<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewsClass
 *
 * @author Рой
 */
class viewsClass {
    
    function __construct() {
        if ((heretic::$_config['debug']) && errorClass::getCountError()) {
            echo "<strong>Текущая ошибка:</strong>" . errorClass::getError();
        }
    }
    
    
    /*
     * 09-2014
     * Функция рендеренга страницы
     * roy
     */

    public function renderPage($page, $arguments = '') {
        
        include_once heretic::$_path['template'] . 'inner.php';
        include_once heretic::$_path['template'] . 'head.php';
        include_once heretic::$_path['template'] . 'header.php';

        /***********WORK PLACE****************/
        
        if (is_readable($page) == false) {
            errorClass::getPageError('404');
        }else{
            include $page;
        }
        
        include_once heretic::$_path['template'] . 'footer.php';
        
    }
    
    public function partialRenderPage($page, $arguments = '') {
        if (is_readable($page) == false) {
            errorClass::getPageError('404');
        }else{
            include $page;
        }
        
    }
    
    /*
     * 15-10-2014
     * Функция вставки дополнительного шаблона
     * roy
     */
    
    public function innerPage($page, $arguments = ''){
        
        $path = heretic::$_path['views'] . $page . '.php';
        $this->partialRenderPage($path, $arguments);
        
    }
    
    
    /*
     * 17-12-2014
     * Добавление шаблонов
     * roy
     */
            
    public function includeTemp($url){
        include_once $url;
    }
    
    
    /*
     * 09-2014
     * Конвертация даты
     * Рой
     */
    
    public function converteDate($date, $type = 'date'){

        switch ($type) {
            case 'onlyDate': $result = $this->onlyDate($date); break;
            case 'onlyDay': $result = $this->onlyDay($date); break;
            case 'onlyMonth': $result = $this->onlyMonth($date); break;
            case 'news': $result = $this->dateDotted($date); break;
            case 'dateTime': $result = $this->dateTime($date); break;
            case 'date': $result = $this->dateDasher($date); break;
            default: $result = $this->dateDasher($date); break;
        }
        
        return $result;
        
    }
    
    //только день
    private function onlyDay($date){
        $array = explode(' ', $date);
        $date = $array[0];

        $date_split = explode('-', $date);

        $day = $date_split[2];
        return $day;
    }
    
    //только месяц
    private function onlyMonth($date){
        $array = explode(' ', $date);
        $date = $array[0];

        $date_split = explode('-', $date);

        $month = $date_split[1];

        switch ($month) {
            case '01': $month = 'января'; break;
            case '02': $month = 'февраля'; break;
            case '03': $month = 'марта'; break;
            case '04': $month = 'апреля'; break;
            case '05': $month = 'мая'; break;
            case '06': $month = 'июня'; break;
            case '07': $month = 'июля'; break;
            case '08': $month = 'августа'; break;
            case '09': $month = 'сентября'; break;
            case '10': $month = 'октября'; break;
            case '11': $month = 'ноября'; break;
            case '12': $month = 'декабря'; break;
            default: $month = 'января'; break;
        }
        
        return $month;
    }
    
    
    /*Только дата*/
    private function onlydate($date){
        $array = explode(' ', $date);
        return $array[0];
    }
    
    /*Дата со временем*/
    private function dateTime($date){
        
        $array = explode(' ', $date);
        
        $result = $this->dateDasher($array[0]);
        
        $time = $array[1];
        $time = substr($time, 0, 5);
        $result = $result . ' в ' . $time;
        
        return $result;
    }
    
    /*Дата через тире*/
    private function dateDasher($date){
        
        $array = explode(' ', $date);
        $date = $array[0];

        $date_split = explode('-', $date);

        $year = $date_split[0];
        $month = $date_split[1];
        $day = $date_split[2];

        switch ($month) {
            case '01': $month = 'января'; break;
            case '02': $month = 'февраля'; break;
            case '03': $month = 'марта'; break;
            case '04': $month = 'апреля'; break;
            case '05': $month = 'мая'; break;
            case '06': $month = 'июня'; break;
            case '07': $month = 'июля'; break;
            case '08': $month = 'августа'; break;
            case '09': $month = 'сентября'; break;
            case '10': $month = 'октября'; break;
            case '11': $month = 'ноября'; break;
            case '12': $month = 'декабря'; break;
            default: $month = 'января'; break;
        }
        
        $day = preg_replace('/^0/', '', $day);
        
        $result = $day . ' ' . $month . ' ' . $year;
        
        return $result;
    }
    
    /*дата через точку*/
    private function dateDotted($date){
        
        $array = explode(' ', $date);
        $date = $array[0];


        $date_split = explode('-', $date);

        $year = $date_split[0];
        $month = $date_split[1];
        $day = $date_split[2];
        $result = $day . '.' . $month . '.' . $year; 
        
        return $result;
        
    }
    
    /*-------------------------------------------------------*/
    
    
    /*
     * 09-2014
     * Множественная форма числа
     * Roy
     */
    
    public function smarty_modifier_string_declination($numeric, $many="объявлений", $one="объявление", $two="объявления"){
        
        $numeric = (int) abs($numeric);
        if (($numeric % 100 == 1) || ($numeric % 100 > 20) && ($numeric % 10 == 1)){
            return $one;
        }
        elseif (($numeric % 100 == 2) || ($numeric % 100 > 20) && ($numeric % 10 == 2)){
            return $two;
        }
        elseif (($numeric % 100 == 3) || ($numeric % 100 > 20) && ($numeric % 10 == 3)){
            return $two;
        }
        elseif (($numeric % 100 == 4) || ($numeric % 100 > 20) && ($numeric % 10 == 4)){
            return $two;
        }
        else {
            return $many;
        }
    }
    
    /*------------------------------------------------------------------------*/
    
    
    /*
     * 09-2014
     * Красивый вывод цены и суммы
     * Roy
     */
    
    public function smarty_modifier_sum_convert($string, $format="int"){
	
	if ($format == "int") {
		return intval($string);
	}
	if ($format == "float") {
		$string = str_replace(",",".",$string);
		return floatval($string);
	}
	if ($format == "digit") {
		return number_format($string, 0, "," ," ");
	}
	if ($format == "summa") {
        return number_format($string,0,","," ")." <span class='rur'>руб.</span>";
	}
        if ($format == "float_summa") {
        return number_format($string,2,","," ")." <span class='rur'>руб.</span>";
        }
        if ($format == "summaDay") {
        return number_format($string,0,","," ")." <span class='rur'>руб. / сутки</span>";
	}
    }
    
    /*------------------------------------------------------------------------*/
    
    /*
     * 09-2014
     * Красивая обрезка текста до кол-ва символов, без разрыва слов
     * Roy
     */
    
    public static function previewText($text = '', $length = 500){
        $text = strip_tags($text);
        return self::cropText($text, $length); 
      }
      
      public static function cropText($string, $length){
        $result = implode(array_slice(explode('<br>',wordwrap($string,$length,'<br>',false)),0,1));
        if($result!=$string) {
            if ($result[mb_strlen($result) - 1] == '.' || $result[mb_strlen($result) - 1] == ',') $result = mb_substr($result, 0, mb_strlen($result)-1);
            $result .= '...';
        }    
        return $result;
      }
      
      
      public function smarty_modifier_truncate($string, $length = 80, $etc = '...', 
                                  $break_words = false, $middle = false) 
            { 
          
                if ($length == 0) 
                    return ''; 

                if (mb_strlen($string, 'utf8') > $length) { 
                //if (strlen($string) > $length) { 
                    $length -= mb_strlen($etc, 'utf8'); 
                    //$length -= strlen($etc); 
                    if (!$break_words && !$middle) { 
                        $string = preg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length+1, 'utf8')); 
                        //$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1)); 
                    } 
                    if(!$middle) { 
                        return mb_substr($string, 0, $length, 'utf8').$etc; 
                        //return substr($string, 0, $length).$etc; 
                    } else { 
                        return mb_substr($string, 0, $length/2, 'utf8') . $etc . mb_substr($string, -$length/2, 'utf8'); 
                        //return substr($string, 0, $length/2) . $etc . substr($string, -$length/2); 
                    } 
                } else { 
                    return $string; 
                } 
            } 
      
    
     /*-----------------------------------------------------------------------*/
    
}
