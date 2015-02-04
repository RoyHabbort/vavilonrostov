<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of innerMenuWidget
 *
 * @author Рой
 */
class innerMenuWidget extends widgetClass{
    
    
    
    public function standartMenu($params){
        $page = $params['page'];
        
        if($params['condition'] == 1){
            $result = $this->getStandartMenu($page);
        }else{
            $result = $this->getStandartMenuForParent($page);
        }
        
        
        $activePage = heretic::$active_page;
        
        if(!empty($result)){
            $this->render('_standartMenu', array('result' => $result, 'active_page' => $activePage));
        }
    }
    
    
    
    
    public function index($params){
        /*
        $link = $params['link'];
        $condition = $params['condition'];
        
        $activePage = heretic::$active_page;
        
        if($condition){
            $result = $this->getParent($link);
        }else{
            $result = $this->getPageForMenu($link);
        }
        
        
        if(!empty($result)){
            $this->render('_innerMenu', array('innerPage' => $result, 'active_page' => $activePage));
        }
        */
    }
    
    private function getParent($link){
        
        $model = new page();
        $criteria = " `link` = '{$link}'";
        $thisPage = $model ->getAll('page', $criteria);
        $thisPage = $thisPage[0];
        
        $criteria = " `parent_id` = '{$thisPage['parent_id']}' ORDER BY `sort` ASC";
        $innerPage = $model ->getAll('page', $criteria);
        
        if(empty($innerPage)){
            return false;
        }
        
        foreach ($innerPage as $key => $value) {
            $page = $model->getPageByLink($value['link']);
            $result[] = $page;
        }
        
//        foreach ($result as $key => $value) {
//            $keyRes = explode('__', $key);
//            
//            if (!empty($keyRes)){
//                $result[$key]['group'] = $keyRes[1];
//            }else{
//                $result[$key]['group'] = $key;
//            }
//        }
        
        
        return $result;
    }
    
    private function getPageForMenu($link){
        $model = new page();
        $criteria = " `link` = '{$link}'";
        $thisPage = $model ->getAll('page', $criteria);
        $thisPage = $thisPage[0];
        $criteria = " `parent_id` = '{$thisPage['id_page']}' ORDER BY `sort` ASC";
        $innerPage = $model ->getAll('page', $criteria);
        
        if(empty($innerPage)){
            return false;
        }
        
        
       
        
        foreach ($innerPage as $key => $value) {
            $page = $model->getPageByLink($value['link']);
            $result[] = $page;
        }
        
//        foreach ($result as $key => $value) {
//            $keyRes = explode('__', $key);
//            
//            if (!empty($keyRes[1])){
//                $result[$key]['group'] = $keyRes[1];
//            }else{
//                $result[$key]['group'] = $key;
//            }
//        }
        
        return $result;
    }
    
    
    
    
    /*
     * 28-11-2014
     * Формируем стандартное меню
     * roy
     */
    
    private function getStandartMenu($page){
        
        $model = new Page;
        
        $sql = "SELECT `id_page`, `title`, `link`, `parent_id` FROM `page` WHERE `parent_id` = '{$page['parent_id']}' ORDER BY `sort` ASC";
        
        $result = $model->query($sql);
        
        return $result;
        
    }
    
    
    private function getStandartMenuForParent($page){
        
        $model = new Page;
        
        $sql = "SELECT `id_page`, `title`, `link`, `parent_id` FROM `page` WHERE `parent_id` = '{$page['id_page']}' ORDER BY `sort` ASC";
        
        $result = $model->query($sql);
        
        return $result;
        
    }
    
    
    
    
}
