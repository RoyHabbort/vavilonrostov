<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blockWidget
 *
 * @author Рой
 */
class blockWidget extends widgetClass{
    
    
    
    //Контроллер блоков
    public function controll($params){
        
        $page = $params['page'];
        if(empty($page)){
            return false;
        }
        
        switch ($page['link']) {
            
            
            default:
                return false;
                break;
        }
        
    }
    
    
    //блок stock
    public function stockMain(){
        $model = new page();
        
        $criteria = "`page_type` = 11 ORDER BY `sort` ASC ";
        $presive = $model->getAll('page', $criteria);
        
        $result = array();
        $curent_date = date('Y-m-d');
        $nullDate = '0000-00-00 00:00:00';
        
        if(!empty($presive)){
            foreach ($presive as $key => $value) {
                if(count($result) <= 10){
                    $tt = $model->getPageById($value['id_page']);
                    if($tt['date_end'] >= $curent_date || $tt['date_end'] == $nullDate ){
                        $result[] = $tt;
                    }
                }
            }
        }
        
        $this->render('_stockMain', array('result' => $result));
    }
    
    
    //все акции
    
    public function allStock($params){
        $model = new page();
        
        $curent_date = date('Y-m-d');
        $cur = 0;
        $nullDate = '0000-00-00 00:00:00';
        
        if(!empty($params['opt'])){
            if($params['opt'] == 'archive'){
                $cur = 1;
            }
        }
        
        $criteria = "`page_type` = 11 ORDER BY `sort` ASC";
        $presive = $model->getAll('page', $criteria);
        
        $result = array();
        
        if(!empty($presive)){
            foreach ($presive as $key => $value) {
                $tt = $model->getPageById($value['id_page']);
                
                
                
                
                
                
                if($cur){
                    if($tt['date_end'] < $curent_date && $tt['date_end'] != $nullDate){
                        
                        if($tt['date_end'] == $nullDate){
                            $tt['date_end'] = NULL;
                        }
                        
                        if($tt['date_start'] == $nullDate){
                            $tt['date_start'] = NULL;
                        }
                        
                        $result[] = $tt;
                    }
                }else{
                    if($tt['date_end'] >= $curent_date || $tt['date_end'] == $nullDate){
                        
                        if($tt['date_end'] == $nullDate){
                            $tt['date_end'] = NULL;
                        }
                        
                        if($tt['date_start'] == $nullDate){
                            $tt['date_start'] = NULL;
                        }
                        
                        $result[] = $tt;
                    }
                }
                
                
                
            }
        }
        
        $this->render('_stockAll', array('result' => $result));
    }
    
    
    
    
    
    //Блок новостей на главной
    public function news(){
        
        
        $model = new Page();
        
        $criteria = "`page_type` = 10 ORDER BY `date_create` DESC LIMIT 3";
        $presive = $model->getAll('page', $criteria);
        
        $result = array();
        if(!empty($presive)){
            foreach($presive as $key => $value){
                $result[] = $model->getPageById($value['id_page']);
            }
        }
        
        
        $this->render('_news', array('result' => $result));
    }
    
    
    /*
     * 13-01-2014
     * Меню типов магазинов на главной
     * roy
     */
    public function menuShop(){
        
        $model = new magazine();
        
        $result = $model->getShopMenuOnMain();
        
        $result = $model->splitMenuOnMain($result);
        
        $this->render('_menuShop', array('result' => $result['main'], 'other' => $result['other']));
    }
    
    //Слайдер на главной
    public function mainSlider(){
  
        $model = new page();
        
        $criteria = "`page_type` = 12 ORDER BY `sort` ASC";
        $presive = $model->getAll('page', $criteria);
        
        
        $result = array();
        if(!empty($presive)){
            
            foreach ($presive as $key => $value) {
                $result[] = $model->getPageById($value['id_page']);
            }
            
        }
        
        $this->render('_mainSlider', array('result' => $result));
    }
    
    
    
    /*
     * 12-2014
     * Выводим теги по категориям
     * roy
     */
    
    public function categoryTags($params){
        
        $model = new page();
        $criteria = " `page_type` = 2 ORDER BY `sort` ASC";
        $result = $model->getAll('page', $criteria);
        
        $this->render('_categoryTags', array('result' => $result, 'activeCategory' => $params['filter']['category']));
    }
    
    
    /*
     * 12-2014
     * Выводим фильтр алфавитных указателей
     * roy
     */
    
    public function alfavitSearch($params){
        
        $model = new page();
        
        $alfavit = array(
            'alfavitKurr' => array('А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ы','Э','Ю','Я'),
            'alfavitLatin' => array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'),
            'alfavitNumeric' => array('1','2','3','4','5','6','7','8','9')
        );
        
        $result = '';
        
        $this->render('_alfavitSearch', array('result' => $result, 'alfavit' => $alfavit, 'activeLetter' => $params['filter']['letter']));
    }
    
    
    
    /*
     * 12-01-2015
     * Похожие магазины
     * roy
     */
    
    public function similarShop($params){
        
        $modelShop = new magazine();
        
        $similarShop = $modelShop->getSimilarShop($params);
        
        heretic::Widget('list', array(
                        'data' => $similarShop,
                        'views' => '_magazine',
                        'count_elment' => 10,
                        'pagination_cout' => 9999,
                        'pagination_type' => 4,
                        'page' => 1,
                        'paginationTemplate' => '_paginMagaz',
                        'href' => ''
                    ));
        
    }
    
    
    //Карта в контактах
    public function map(){
        $this->render('_map');
    }
    
    //вывод развлечений
    public function entertainment(){
        
        $model = new page();
        
        $result = $model->getEntertainment();
        
        $this->render('_entertainment', array(
            'result' => $result
        ));
        
    }
    
    //вывод ресторанов
    public function restoraunt(){
        $model = new page();
        
        $result = $model->getRestoraunt();
        
        $this->render('_entertainment', array(
            'result' => $result
        ));
    }
    
    
    //аренда помещений
    public function arendOptions(){
        
        $model = new page();
        
        $this->render('_arendOptions', array(
        ));
        
    }
    
    //якорные арендаторы
    public function arendBrand(){
        
        $model = new page();
        
        $result = $model->getArendBrand();
        
        $this->render('_arendBrand', array(
            'result' => $result
        ));
    }
    
    
}
