<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of magazine
 *
 * @author Рой
 */
class magazine extends modelsClass{
    
    /*
     * 10-01-2014
     * Лист по магазинам, с фильтрами
     * roy
     */
    
    
    public function listShopByFilter($params){
        
        $params = $this->validate($params, $rules = array(
            'string' => 'category, letter'
        ));
        
        $modelPage = new page();
        
        $sql = "SELECT * FROM `page` WHERE `page_type` = 3 ORDER BY `title` ASC";
        $Magazine = $this->query($sql);
        
        $allMagazine = array();
        foreach ($Magazine as $key => $value) {
            $allMagazine[] = $modelPage->getPageById($value['id_page']);
        }
        
        $resultMagazine = array();
        $regExp = "/^{$params['letter']}/i";
        
        foreach ($allMagazine as $key => $value) {
            $bool = true;
            
            //проверка категории
            if(!empty($params['category']) && ($value['category'] != $params['category'])){
                $bool = false;
            }
            
            //проверка letter
            if(!empty($params['letter']) && ( !preg_match($regExp, $value['title'])  )){
                $bool = false;
            }
            
            if($bool){
                $resultMagazine[] = $allMagazine[$key];
            }
            
            
        }
        
        return $resultMagazine;
        
    }
    
    
    
    /*
     * 12-01-2014
     * Выдать имя категории
     * roy
     */
    
    public static function getCategoryName($idCategory){
        
        $model = new modelsClass();
        
        $params['id_category'] = $idCategory;
        
        $params = $model->validate($params, $rules = array('string' => 'id_category'));
        
        $sql = "SELECT `title` FROM `page` WHERE `id_page` = '{$params['id_category']}' LIMIT 1";
        
        return $model->query($sql);
        
    }
    
    
    /*
     * 12-01-2015
     * Похожие магазины
     * roy
     */
    
    public function getSimilarShop($params){
        
        $model = new page();
        
        $params = $this->validate($params, $rules = array(
            'string' => 'category, id_page'
        ));
        
        $sql = "SELECT * FROM `page` p
                INNER JOIN `field_inner_category` fic ON fic.page_id_category = p.id_page
                WHERE fic.field_content_category = {$params['category']} AND p.id_page != {$params['id_page']}";
                
        $similarShop = $this->query($sql);        
        $result = array();        
        
        for($i=0; $i<10; $i++){
            if(!empty($similarShop[$i])){
                $result[] = $model->getPageById($similarShop[$i]['id_page']);
            }
        }
                
        return $result;        
        
    }
    
    
    
    /*
     * 13-01-2015
     * Формируем массив для меню на главной
     * roy
     */
    
    public function getShopMenuOnMain(){
        
        $criteria = " `page_type` = 2 ORDER BY `sort` ASC";
        $allCategory = $this->getAll('page', $criteria);
        
        foreach ($allCategory as $key => $value) {
            $sql = "SELECT * FROM `page` p
                INNER JOIN `field_inner_category` fic ON fic.page_id_category = p.id_page
                WHERE fic.field_content_category = {$value['id_page']}";
                
            $ShopThisCategory = $this->query($sql);
            $allCategory[$key]['count_shop'] = count($ShopThisCategory);
        }
        
        return $allCategory;
        
    }
    
    
    
    /*
     * 13-01-2015
     * Сплитим массив меню на главной на два состовляющих
     * Первые, те которые выводятся сразу,
     * Иные в раздел "другие"
     * roy
     */
    
    public function splitMenuOnMain($arrayMenu){
        
        $result = array();
        
        if(!empty($arrayMenu)){
            foreach ($arrayMenu as $key => $value) {
            
                if($value['id_page'] == 23 || $value['id_page'] == 16 || $value['id_page'] == 17 || $value['id_page'] == 19 || $value['id_page'] == 10 || $value['id_page'] == 15){

                    $result['other'][] = $value; 

                }else{
                    $result['main'][] = $value; 
                }

            }
        }
        
        return $result;
        
    }
    
    
    
    /*
     * 14-01-2015
     * Получить список этажей
     * roy
     */
    
    
    public function getFloor(){
        
        $sql = "SELECT `selecter_filter` FROM `field` WHERE `field_name` = 'floor' LIMIT 1";
        
        $floor = $this->query($sql);
        return unserialize($floor);
        
    }
    
    
    
    /*
     * 15-01-2015
     * Получить магазины для карты
     * roy
     */
    
    public function getShopByMap($category){
        
        $modelPage = new page();
        
        $sql = "SELECT * 
                FROM `shop_map`
                WHERE 1";
        
        $allMagazine = $this->query($sql);
        
        $resultArray = array();
        $allShop = array();
        
        if(!empty($allMagazine)){
            foreach ($allMagazine as $key => $value) {
                if($value['page_id'] > 0){
                    $allShop[$value['shop_path']] = $modelPage->getPageById($value['page_id']);
                }else{
                    
                    if($value['page_id'] == -1){
                        $allShop[$value['shop_path']] = array(
                            'title' => 'Банкоматы',
                            'category' => -3
                        );
                    }
                    
                }
                
                $allShop[$value['shop_path']]['shop_path'] =  $value['shop_path'];
                $allShop[$value['shop_path']]['path'] =  $value['path'];
                $allShop[$value['shop_path']]['x'] =  $value['x'];
                $allShop[$value['shop_path']]['y'] =  $value['y'];
                $allShop[$value['shop_path']]['type'] =  $value['type'];
            }
        }
        
        if(!empty($allShop)){
            foreach ($allShop as $key => $value) {
                
                if(empty($value['category'])){
                    if(!empty($value['page_type']['id_page_type'])){
                        if($value['page_type']['id_page_type'] == 6){
                            $allShop[$key]['category'] = -1;
                        }elseif($value['page_type']['id_page_type'] == 7 || $value['page_type']['id_page_type'] == 8){
                            $allShop[$key]['category'] = -2;
                        }else{
                            $allShop[$key]['category'] = -4;
                        }
                    }else{
                        $allShop[$key]['category'] = -4;
                    }
                    
                    
                }
                
                $allShop[$key]['shopCategory'] = $category[$allShop[$key]['category']];
            }
        }
        
        return $allShop;
        
    }
    
    
    /*
     * 15-01-2015
     * Получение всех категорий для карты
     * roy
     */
    
    public function getShopCategoryFull(){
        
        $model = new page();
        
        $sql = "SELECT * FROM `page` WHERE `page_type` = 2 ORDER BY `sort`";
        
        $category = $this->query($sql);
        
        
        if(!empty($category)){
            foreach ($category as $key => $value) {
                
                
                switch ($value['id_page']){
                    case 8:
                        //Одежда
                        $category[$key]['color'] = 'f1';
                        break;
                    
                    case 9:
                        //Бытовая техника и электроника
                        $category[$key]['color'] = 'f2';
                        break;
                    
                    case 10:
                        //Мобильная связь
                        $category[$key]['color'] = 'f3';
                        break;
                    
                    case 11:
                        //Аксессуары
                        $category[$key]['color'] = 'f4';
                        break;
                    
                    case 12:
                        //обувь
                        $category[$key]['color'] = 'f5';
                        break;
                    
                    case 13:
                        //Спортивные товары
                        $category[$key]['color'] = 'f6';
                        break;
                    
                    case 14:
                        //Красота и здоровье
                        $category[$key]['color'] = 'f7';
                        break;
                    
                    case 15:
                        //Всё для дома
                        $category[$key]['color'] = 'f8';
                        break;
                    
                    case 16:
                        //Сумки и чемоданы
                        $category[$key]['color'] = 'f9'; // цвет бельё
                        break;
                    
                    case 17:
                        //Кожгалантерея
                        $category[$key]['color'] = 'f10';
                        break;
                    
                    case 19:
                        //Услуги
                        $category[$key]['color'] = 'f11';
                        break;
                    
                    case 20:
                        //Продукты
                        $category[$key]['color'] = 'f12';
                        break;
                    
                    case 22:
                        //Товары для детей
                        $category[$key]['color'] = 'f13';
                        break;
                    
                    case 23:
                        //Зоотовары
                        $category[$key]['color'] = 'f14';
                        break;
                    
                    default :
                        $category[$key]['color'] = 'f15';
                        break;
                }
            }
        }
        
        
        $category[] = array(
            'id_page' => -1,
            'title' => 'Рестораны, кафе',
            'color' => 'f16'
        );
        
        $category[] = array(
            'id_page' => -2,
            'title' => 'Развлечения',
            'color' => 'f17'
        );
        
        $category[] = array(
            'id_page' => -3,
            'title' => 'Банкоматы',
            'color' => 'f18'
        );
        
        $category[] = array(
            'id_page' => -4,
            'title' => 'Другие',
            'color' => 'f19'
        );
        
        
        $categoryResult = array();
        if(!empty($category)){
            foreach ($category as $key => $value) {
                $categoryResult[$value['id_page']] = $value;
            }
        }
        
        return $categoryResult;
        
    }
    
    
    
    /*
     * 16-01-2015
     * Вывести магазин на карте
     * roy
     */
    
    public function getShopOnMap($idPage){
        
        $sql = "SELECT `shop_path` FROM `shop_map` WHERE `page_id` = {$idPage} LIMIT 1";
        $shopPath = $this->query($sql);
        
        if(empty($shopPath)|| !$shopPath){
            return false;
        }
        
        $num = str_replace('shop-', '', $shopPath);
        
        switch (true) {
            case $num <= 3:
                $floor = 0;
                break;
            
            case $num <= 4:
                $floor = 15;
                break;
            
            case $num <= 5:
                $floor = 25;
                break;
            
            case $num <= 24:
                $floor = 3;
                break;
            
            case $num <= 25:
                $floor = 4;
                break;
            
            case $num <= 45:
                $floor = 2;
                break;
            
            case $num <= 91:
                $floor = 1;
                break;

            default:
                $floor = 1;
                break;
        }
        
        
        $result = array(
            'shopPath' => $shopPath,
            'floor' => $floor
        );
        
        return $result;
        
    }
    
    
    
    /*
     * 20-01-2015
     * Получить категорию магазина по его(магазина) id 
     * roy
     */
    
    public static function getCategoryNameById($idPage){
        
        $model = new page();
        
        if($idPage == -1){
            return "Рестораны и кафе"; 
        }
        elseif($idPage == -2){
            return "Развлечения";
        }
        elseif($idPage < 0){
            return "Другое";
        }
        
        $sql = "SELECT p.title 
                FROM `page` p
                WHERE p.id_page = {$idPage} LIMIT 1 ";
        
        return $model->query($sql);        
                
    }
            
    
}
