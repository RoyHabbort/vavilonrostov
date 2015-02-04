<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of excel
 *
 * @author Рой
 */
class excel extends PHPExcel{
    
    private $arrayPrice = array();
    private $arraySubPrice = array();
    private $workArray = array();
    private $parent = array();
    
    public function index($fileName){
        
        //получаем массив из таблицы
        $this->workArray = $this->readExcel($fileName);
    
        $this->getTwoArray();
        
        $this->writePrice($this->arrayPrice);
        $this->writeSubPrice($this->arraySubPrice);
        
        return true;
    }
    
    
    
    private function writePrice($params){
        
        $base = new databaseClass();
        foreach ($params as $key => $value) {
            
            $sort = $key + 1;
            
            $sql = "INSERT INTO `price` (`price`, `sort`, `key`) VALUES ('{$value[1]}', '{$sort}', '{$value['key']}')";
            $base->query($sql);
            
        }
        
    }
    
    private function writeSubPrice($params){
        
        $base = new databaseClass();
        foreach ($params as $key => $value) {
            
            $summ = (integer) $value[3];
            
            $sql = "INSERT INTO `sub_price` (`sub_price`, `summ`, `price_id`) VALUES ('{$value[2]}', '{$summ}', '{$value['key']}')";
            $base->query($sql);
            
        }
        
    }
    
    private function getTwoArray(){
        foreach ($this->workArray as $key => $value) {
            if ($value[0] == 1){
                $this->parent = uniqid();
                $array = $value;
                $array['key'] = $this->parent;
                $this->arrayPrice[] = $array;
            }else{
                $array = $value;
                $array['key'] = $this->parent;
                $this->arraySubPrice[] = $array;
            }
        }
    }
    
    
    public function readExcel($fileName){
        $excel = PHPExcel_IOFactory::load($fileName);
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();
        
        $result = array();
        
        $rowIterator = $sheet->getRowIterator();
        foreach ($rowIterator as $key => $row) {
            // Получили ячейки текущей строки и обойдем их в цикле
            $cellIterator = $row->getCellIterator();


            foreach ($cellIterator as $key2 => $cell) {
                $result[$key][$key2] = $cell->getCalculatedValue();
            }

        }
        
        return $result;
        
    }
    
}
