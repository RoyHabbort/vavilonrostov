<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of databaseClass
 *
 * @author Рой
 */
class databaseClass {
    
    
    private $db_host = "";
    private $db_login = "";
    private $db_password = "";
    private $db_name = "";
    public $db;
    
    
    private $debug;
    private $mysql_error;
    private $connect;
    
    public function selectDatabase($param) {
        $this->db_host = $param['db_host'];
        $this->db_login = $param['db_login'];
        $this->db_password = $param['db_password'];
        $this->db_name = $param['db_name'];
        return $this->conectDatabase();
    }
    
    public function closeDatabase(){
        $this->unconectionDatabase();
    }

        private function conectDatabase() {
      
        if (!$this->db = mysql_connect($this->db_host,$this->db_login,$this->db_password)){
            errorClass::$_error[] = 101;
            return false;
        }
        if  (!mysql_select_db($this->db_name ,$this->db)){
            errorClass::$_error[] = 102;
            return false;
        }
        else{
            return true;
        }
    }
    
    private function unconectionDatabase() {
        mysql_close($this->db);
    }
    
    
    
    /**Выполняем запрос*/
    public function query($sql,$debug = FALSE){
        mysql_query("SET NAMES utf8");
        $this->debug = $debug;

        if($debug) $this->print_in_HTML("SQL", $sql);
        if("" == ($result_identifier = mysql_query($sql)))$result_identifier = array();
        $mysql_error = mysql_error();
        $this->mysql_error = $mysql_error;
        if($debug && "" != $mysql_error) $this->print_in_HTML("Error", $mysql_error);
        if(!empty($mysql_error))return NULL;

        if(preg_match("/^SELECT/i",$sql)){
            if (preg_match("/LIMIT 1/i",$sql)){
                if(0 == mysql_num_rows($result_identifier))return NULL;
                return mysql_result($result_identifier,0);
            }
            else{
                $i=0;
                while ($result = mysql_fetch_array($result_identifier,MYSQL_ASSOC)){
                        $result_array[$i] = $result;
                        $i++;
                }
                if (!isset($result_array)) $result_array = array();
                return $result_array;
            }
        }
        
        if(empty($mysql_error)) return TRUE;
    }

    /**Выводит запрос или ошибку*/
    function print_in_HTML($type, $text){
        echo "<div class=mini>";
        echo $type."<br>";
        echo $text."<br><br>";
        echo "</div>";
        return TRUE;
    }
      
    /**Узнаем количество записей*/
    function numrows($query){
        $records = mysql_NumRows($this->$db, mysql_query($query));
        return $records;
    }
    
    function anotherNumRow(){
        return mysql_affected_rows();
    }
  
    function last_insert_id() {
        return mysql_insert_id();
    }
      
    
    
    /* 
     * 08-2014
     * Блок валидация форм
     * Roy
     */
    
    
    public function validate($params, $rules = array()){
        
        
        $valid_errors= array();
        foreach ($params as $key => $value) {
            $valid_errors[$key] = '';
        }
        
        foreach ($rules as $key => $value) {
             $pole = explode(',', $value);
             
             switch ($key) {
                 case 'required':
                     
                     foreach ($pole as $key2 => $value2) {
                        if (!$this->valid_required($params[trim($value2)]))
                            $valid_errors[trim($value2)] .='Данное поле обязательно для заполнения. ';
                     }

                     break;
                 case 'email':
                     
                     foreach ($pole as $key2 => $value2) {
                        if (!$this->valid_email($params[trim($value2)]))
                            $valid_errors[trim($value2)] .='Неверный формат почты. ';
                     }

                     break;
                 case 'phone':
                     
                     foreach ($pole as $key2 => $value2) {
                        if (!$this->valid_phone($params[trim($value2)]))
                            $valid_errors[trim($value2)] .='Неверный формат телефона. ';
                     }

                     break;
                 case 'string':
                     
                     foreach ($pole as $key2 => $value2) {
                        $params[trim($value2)] = $this->valid_string($params[trim($value2)]);
                     }

                     break;
                 case 'number':
                     
                   
                     foreach ($pole as $key2 => $value2) {
                     $value2 = trim($value2);
                        if(!empty($value2)){
                            if (!$this->valid_number($params[trim($value2)]))
                                $valid_errors[trim($value2)] .= 'Значение данного поля должно быть числом. ';
                        }
                     }

                     break;
                 case 'text':
                     
                     foreach ($pole as $key2 => $value2) {
                        $params[trim($value2)] = $this->valid_text($params[trim($value2)]);
                     }
                     

                     break;
                 case 'equal':
                     if (!$this->valid_equil($params[trim($pole[0])], $params[trim($pole[1])]))
                             $valid_errors[trim($pole[0])] = 'Значение полей не совпадает';

                     break;   
                 default:
                     
                     break;
             }
             
        }
        
        foreach ($params as $key => $value) {
            if ($valid_errors[$key] == '') unset($valid_errors[$key]);
            
        }
        
        $params['valid_errors'] = $valid_errors;
        return $params;
        
    }
    
    
    

    private function valid_equil($param1, $param2){
        if ($param1 != $param2) return false;
            else return true;
    }
    
    private function valid_text($param){
        $param = (string) $param;
        $param = mysql_real_escape_string($param);
        return $param;
    }
    
    private function valid_number($param){
        $param = (integer) $param;
        if (is_int($param)) return true;
            else return false;
    }
    
    
    private function valid_string($param){
        $param = (string) $param;
        $param = mysql_real_escape_string($param);
        $param = strip_tags($param);
        return $param;
    }


    private function valid_required($param){
        if (!empty($param)&&isset($param)) return true;
            else return false;
    }
    
    private function valid_email($param){
        if (strripos($param, '@')) return true;
            else return false;
    }
    
    private function valid_phone($param){
        $pattern = '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/';
        
        if (preg_match($pattern, $param)) return true;
            else return false;
    }
    
    /*
     * 08-2014
     * Конец блока валидации
     */
    
    
    
    /**Выполняем запрос статично*/
    public static function queryStatic($sql,$debug = FALSE){
        mysql_query("SET NAMES utf8");

        if("" == ($result_identifier = mysql_query($sql)))$result_identifier = array();
        $mysql_error = mysql_error();
     
        if(!empty($mysql_error))return NULL;

        if(preg_match("/^SELECT/i",$sql)){
            if (preg_match("/LIMIT 1/i",$sql)){
                if(0 == mysql_num_rows($result_identifier))return NULL;
                return mysql_result($result_identifier,0);
            }
            else{
                $i=0;
                while ($result = mysql_fetch_array($result_identifier,MYSQL_ASSOC)){
                        $result_array[$i] = $result;
                        $i++;
                }
                if (!isset($result_array)) $result_array = array();
                return $result_array;
            }
        }
        
        if(empty($mysql_error)) return TRUE;
    }
    
    
}
