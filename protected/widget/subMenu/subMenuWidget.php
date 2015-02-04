<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of subMenu
 *
 * @author Рой
 */
class subMenuWidget extends widgetClass {
    
    public function index(){
        
        $result = array('Заказ столика', 'Бронирование номеров', 'Сауна', 'Бассейн', 'Конгресс-холл');
        
        $this->render('_subMenu', array('result' => $result));
    }
    
}
