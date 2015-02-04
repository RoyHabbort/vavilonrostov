<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shopController
 *
 * @author Рой
 */
class shopController extends controllerClass{
    
    
    /*
     * 10-2014
     * Установка активной страницы
     * roy
     */
    
    private function setActivePage($link){
        heretic::$active_page = $link;
    }
    
    /*
    * 10-01-2015
    * Вывод списка магазинов
    * roy
    */
    
    public function index($params){
        
        $model = new page();
        $modelMagazine = new magazine();
        $this->setActivePage('shop');
        
        $filterMagazine = array();
        $filterMagazine['category'] = (!empty($_GET['category'])) ? $_GET['category'] : '';
        $filterMagazine['letter'] = (!empty($_GET['letter'])) ? $_GET['letter'] : '';
        
        $pagination = (!empty($_GET['page'])) ? $_GET['page'] : '';
        
        $shopByFiltred = $modelMagazine->listShopByFilter($filterMagazine);
        
        
        
        if (!isset($_SERVER["HTTP_X_PJAX"])){
            $this->render('listMagazine', array(
                'result' => $shopByFiltred,
                'link' => 'shop',
                'pagination' => $pagination,
                'filter' => $filterMagazine
            ));
        }else{
            $this->partialRender('listMagazine', array(
                'result' => $shopByFiltred,
                'link' => 'shop',
                'pagination' => $pagination,
                'filter' => $filterMagazine
            ));
        }
        
        
    }
    
    
    
    
    /*
     * 14-01-2014 
     * Выдача магазинов на карте
     * roy
     */
    
    public function shopMap(){
        
        
        $this->setActivePage('shopMap');
        
        
        $this->render('shopMap', array(
            'link' => 'shopMap'
        ));
        
    }
    
    
}
