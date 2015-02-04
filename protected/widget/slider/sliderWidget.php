<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sliderWidget
 *
 * @author Рой
 */
class sliderWidget extends widgetClass{
    
    public function index() {
        
        $model = new page();
        $criteria = "1 ORDER BY `sort` ASC";
        $result = $model->getAll('slider', $criteria);

        $this->render('_slider', array('result' => $result));
    }
    
    
    public function appartament(){
        
        $this->render('_appartament');
        
    }
    
}
