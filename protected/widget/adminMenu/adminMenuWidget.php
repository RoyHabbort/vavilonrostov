<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminMenuWidget
 *
 * @author Рой
 */
class adminMenuWidget extends widgetClass{
    
    public function index(){
        
        $this->render('_adminMenu', array('adminMenu' => heretic::$_hereticMenu));
    }
    
    
    public function hereticMenu(){
        $this->render('_menu', array('adminMenu' => heretic::$_hereticMenu));
    }
    
    public function adminMenu(){
        
        $this->render('_adminMenu', array('adminMenu' => heretic::$_hereticMenu));
    }
    
}
