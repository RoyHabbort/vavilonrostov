<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of news
 *
 * @author Рой
 */
class news extends modelsClass{
    
    
    public function getNewsForBlock(){
        $sql = "SELECT * FROM `news` WHERE 1 ORDER BY `date` DESC LIMIT 3";
        $result = $this->query($sql);
        if($result) return $result;
            else return false;
    }
    
}
