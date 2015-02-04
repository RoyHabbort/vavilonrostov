<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainMenuWidget
 *
 * @author Рой
 */
class mainMenuWidget extends widgetClass{
    
    public function index($params){
        
        $activePage = heretic::$active_page;
        //$activePage = $this->getMenuActiveElement($activePage);
        
        $model = new page();
        $menu = $model->getTopMenu();
        $this->render('mainMenu', array('menu' => $menu, 'active_page' => $activePage));
        
    }
    
    
    private function getMenuActiveElement($activePage){
        
        if($activePage == '/') return '/';
        $model = new page();
        $typeMenu = $model->getTopMenuType();
        
        $criteria = "`link` = '{$activePage}'";
        $page = $model->getAll('page', $criteria);
        $page = $page[0]; 
        
        if(empty($page['page_type'])){
            return false;
        }
        
        $schet = 0;
        
        
        while(($typeMenu != $page['page_type']) || (!empty($page['page_type'])) || ($schet == 10)){
            $parent = $page['parent_id'];
            $page = $model->getById('page', $parent);
            $schet++;
        }
        
        $activeMenu = $page['link'];
        return $activeMenu;
        
    }
    
    
    
    
    /*
     * 26-11-2014
     * Нижнее меню
     * roy
     */
    
    public function footerMenu(){
        
        $model = new page();
        $result = $model->getFooterMenu();
        
        $this->render('_footerMenu', array('result' => $result));
    }
    
    
    
    
}
