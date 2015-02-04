<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelsClass
 *
 * @author Рой
 */
class modelsClass extends databaseClass{
     
    /*
     * 3-09-2014
     * Запрос на получение всех данный таблицы
     * roy
     */
    public function getAll($table, $criteria = '1', $debug = 0){
        $sql = "SELECT * FROM {$table} WHERE $criteria";
        if($debug) echo $sql; 
        $result = $this->query($sql);
        if($result) return $result;
            else return false;
    }
    
    
    /*
     * 3-09-2014
     * Запрос на получение одной строки из таблицы
     * roy
     */
    
    public function getOne($table, $criteria = '1'){
        $sql = "SELECT * FROM {$table} WHERE $criteria";
        $result = $this->query($sql);
        if($result) return $result[0];
            else return false;
    }
    
    /*
     * 3-09-2014
     * Запрос на получение записи из таблицы по id
     * roy
     */
    
    public function getById($table, $id){
        $sql = "SELECT * FROM {$table} WHERE `id_{$table}` = '{$id}'";
        $result = $this->query($sql);
        if($result) return $result[0];
            else return false;
    }
    
    /*
     * 3-09-2014
     * Запрос на удаление записи из таблицы по id
     * roy
     */
    
    public function DeleteById($table, $id){
        $sql = "DELETE FROM `{$table}` WHERE `id_{$table}` = '{$id}'";
        $this->query($sql);
        $result = $this->anotherNumRow();
        if($result) return true;
            else return false;
    }
    
    
    
    /*
     * 2-10-2014
     * Запрос добавления материала
     * roy
     */
    
    public function AddInTable($table, $params, $rules, $debug = 0){
        
        $params = $this->validate($params, $rules);
        
        if(empty($params['valid_errors'])){
            
            unset($params['valid_errors']);
            $pole = '';
            $val = '';
            foreach ($params as $key => $value) {
                $pole .= "`$key`, ";
                $val .= "'{$value}', ";
            }
            
            $pole = substr($pole, 0, -2);
            $val = substr($val, 0, -2);
            
            $sql = "INSERT INTO `$table` ($pole) VALUES ($val)";
            if($debug) echo $sql;
            $result = $this->query($sql);
            if($result){
                return true;
            }else{
                return array('errors' => array('mysql_error' => 'Ошибка бд'));
            }
        }else{
            return array('errors' => $params['valid_errors']);
        }
        
    }
    
    
    /*
     * 2-10-2014
     * Запрос редактирования материала
     * roy
     */
    
    public function editById($table, $params, $rules, $id, $debug = 0){
        
        $params = $this->validate($params, $rules);
        
        if(empty($params['valid_errors'])){
            
            unset($params['valid_errors']);
            $edit = '';
            foreach ($params as $key => $value) {
                $edit .= "`$key` = '$value', ";
                
            }
            
            $edit = substr($edit, 0, -2);
            
            $sql = "UPDATE `{$table}` SET {$edit} WHERE `id_{$table}` = '{$id}' ";
            if($debug) echo $sql;
            $result = $this->query($sql);
            if($result){
                return true;
            }else{
                return array('errors' => array('mysql_error' => 'Ошибка бд'));
            }
        }else{
            return array('errors' => $params['valid_errors']);
        }
    
    }
    
    
    
    
    /*
     * 8-12-2014
     * перевод линка в транслит
     * roy
     */
    
    public function toTranslite($title) {
        
        $link = heretic::translitString($title);
        
        $sql = "SELECT * FROM `page` WHERE `link` = '{$link}'";
        
        $result = $this->query($sql);
        
        if(count($result) > 0){
            $add = count($result) + 1;
            $link = $link . '_' . $add;
        }
        
        return $link;
        
    }
    
    
    
}
