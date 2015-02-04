<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of breadCrumbsWidget
 *
 * @author Рой
 */
class breadCrumbsWidget extends widgetClass {
    
    
    public function index($link){
        
        $breadArray = array();
        $model = new page();
        
        $criteria = " `link` = '{$link}'";
        $breadNow = $model ->getAll('page', $criteria);
        $breadNow = $breadNow[0];
        $breadArray[] = $breadNow;
        $parent = $breadNow['parent_id'];
        
        while($parent){
            $breadNow = $model ->getById('page', $parent);
            $breadArray[] = $breadNow;
            $parent = $breadNow['parent_id'];
        }
        
        $breadArray = array_reverse($breadArray);
        
        $this->render('_breadcrumbs', array('result' => $breadArray));
        
    }
    
}
