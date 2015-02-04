<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shopMapWidget
 *
 * @author Рой
 */
class shopMapWidget extends widgetClass{
    
    
    /*
     * 15-01-2015
     * Вывести всю карту
     * roy
     */
    
    public function shopMapFull(){
        
        $model = new magazine();
        
        $shopCategory = $model->getShopCategoryFull();
        
        $shopFull = $model->getShopByMap($shopCategory);
        
        $this->render('shopMapFull', array(
            'shop_category' => $shopCategory,
            'all_shop' => $shopFull 
        ));
        
    }
    
    /*
     * 15-01-2015
     * Отобразить этаж
     * roy
     */
    
    public function showFloor($params){
        
        $floor = '_' . $params['floor'] . '_floor';
        $this->render($floor, array('all_shop' => $params['all_shop']));
        
    }
    
    
    /*
     * 16-01-2015
     * Отобразить малую карту
     * roy
     */
    
    public function shopMapSmall($params){
        
       $model = new magazine();
       $modelPage = new page();
       
       $shopCategory = $model->getShopCategoryFull();
       $shopFull = $model->getShopByMap($shopCategory);
       
       $shop = $modelPage->getPageByLink($params['shop']);
       
       $shopInfo = $model->getShopOnMap($shop['id_page']);
       
        if($shopInfo){
           
            $this->render('shopMapSmall', array(
                'shop' => $shop,
                'shopInfo' => $shopInfo,
                'all_shop' => $shopFull    
            ));
            
        }
        
        
    }
    
    
    /*
     * 20-01-2015
     * Вывод карты для админки
     * roy
     */
    
    public function shopMapAdmin(){
        
        $model = new magazine();
        
        $shopCategory = $model->getShopCategoryFull();
        
        $shopFull = $model->getShopByMap($shopCategory);
        
        
        $this->render('shopMapAdmin', array(
            'shop_category' => $shopCategory,
            'all_shop' => $shopFull 
        ));
        
    }
    
}
