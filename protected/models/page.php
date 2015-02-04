<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page
 *
 * @author Рой
 */
class page extends modelsClass{
    
    private $bdError = array('errors' => array('mysql_error' => 'Ошибка БД')); 
    
    /*
     * 21-10-2014
     * Получить ссылку на главное  
     * roy
     */
    
    public function getTopMenuType(){
        $sql = "SELECT `page_type` FROM `top_menu` WHERE `id_top_menu` = 1 LIMIT 1";
        $result = $this->query($sql);
        return $result;
    }
    
    
    /*
     * 10-2014
     * Получение инфы о верхнем меню
     * roy
     */
    
    public function getTopMenu(){
        $sql = "SELECT * FROM `page` p
                WHERE p.page_type = 1 ORDER BY `sort` ASC";
        $result = $this->query($sql);
        return $result;
    }
    
    
    /*
     * 11-2014
     * Получение имени родительского элемента
     * roy
     */
    
    public function getParentName($idParent){
        
        $sql = "SELECT `title` FROM `page` WHERE `id_page` = '{$idParent}'";
        $result = $this->query($sql);
        
        if(!empty($result[0]['title'])){
            return $result[0]['title'];
        }else{
            return false;
        }
        
    }
    
    /*
     * 18-12-2014
     * Получение имени категории
     * roy
     */
    
    public function getCategoryMagazin($idPage){
        $presive = $this->getPageById($idPage);
        
        $sql = "SELECT `title` FROM `page` WHERE `id_page` = '{$presive['category']}' LIMIT 1";
        $result = $this->query($sql);
        
        return $result;
    }
    
    
    /*
     * 10-2014
     * Получение данных для главной страницы
     * roy
     */
    
    public function getMainPage(){
        $sql = "SELECT * FROM `page` p 
                INNER JOIN `top_menu` t ON t.page_type = p.page_type 
                WHERE 1 ORDER BY `sort` ASC";
        $result = $this->query($sql);
        return $result[0];
    }
    
    
    /*
     * 20-10-2014
     * Получение полных данных о странице по ссылке
     * roy
     */
    
    public function getPageByLink($linkPage){
        $params['link'] = $linkPage;
        $params = $this->validate($params, $rules = array(
                'required' => 'link',
                'string' => 'link'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        //получаем основные параметры страницы
        $sql = "SELECT * FROM `page` p WHERE p.link = '{$params['link']}'";
        $result = $this->query($sql);
        if(!empty($result)){
           $result = $result[0]; 
        }
        
        if(!$result){
            return $this->bdError;
        }
        
        //получаем тип страницы
        $sql = "SELECT * FROM `page_type` pt WHERE pt.id_page_type = '{$result['page_type']}'";
        $pageType = $this->query($sql);
        $result['page_type'] = $pageType[0];
        
        //получаем доп. поля для данного материала
        $sql = "SELECT * FROM `field` f
                INNER JOIN `field_aux` fa ON fa.field_id = f.id_field
                INNER JOIN `field_type` ft ON f.field_type_id = ft.id_field_type
                WHERE fa.page_type_id = '{$result['page_type']['id_page_type']}'";
        $result['page_type']['fields'] = $this->query($sql);
        
        //получаем фильтры для изображений
        foreach ($result['page_type']['fields'] as $key => $value) {
            
            if($value['type'] == 'image' || $value['type'] == 'single_image'){
                $result['page_type']['fields'][$key]['image_filter'] = $this->getImageFilterById($value['image_filter']);
                $result[$value['field_name']] = $this->getAuxFieldImageById($value['field_name'], $result['id_page'], $result['page_type']['fields'][$key]['image_filter']);
                
            }else{
                $result[$value['field_name']] =  $this->getAuxFieldById($value['field_name'], $result['id_page']);
            }
            
        }
        
        return $result;
        
    }
    
    /*
     * 20-10-2014
     * Получить содержимое поля для страницы
     * roy
     */
    
    private function getAuxFieldById($fieldName, $idPage){
        $sql = "SELECT `field_content_{$fieldName}` FROM `field_inner_{$fieldName}` WHERE `page_id_{$fieldName}` = '{$idPage}' LIMIT 1";
        return $this->query($sql);
    }
    
    
    /*
     * 20-10-2014
     * Получить содержимое поля изображения для страницы
     * roy
     */
    
    private function getAuxFieldImageById($fieldName, $idPage, $imageFilter){
        $sql = "SELECT `field_content_{$fieldName}` FROM `field_inner_{$fieldName}` WHERE `page_id_{$fieldName}` = '{$idPage}'";
        $allImage = $this->query($sql);
        $result = array();
        
        foreach ($allImage as $key => $value) {
            $result[$key]['image'] = $value['field_content_' . $fieldName];
            $result[$key]['thumb_path'] = heretic::$_path['images'] . $imageFilter['thumb_dir'] . '/' . $result[$key]['image'];
            $result[$key]['medium_path'] = heretic::$_path['images'] . $imageFilter['medium_dir'] . '/' . $result[$key]['image'];
            $result[$key]['full_path'] = heretic::$_path['images'] . $imageFilter['full_dir'] . '/' . $result[$key]['image'];
        }
        
        return $result;
    }
    
    
    /*
     * 20-10-2014
     * Получить всю инфу о фильтре по id
     * roy
     */
    
    private function getImageFilterById($idImageFilter){
        $sql = "SELECT * FROM `image_filter` imf 
                    INNER JOIN `thumb_image_filter` tif ON tif.image_filter = imf.id_image_filter 
                    INNER JOIN `medium_image_filter` mif ON mif.image_filter = imf.id_image_filter
                    INNER JOIN `full_image_filter` fif ON fif.image_filter = imf.id_image_filter
                    WHERE imf.id_image_filter = '{$idImageFilter}'";
        $imageFilter = $this->query($sql);  
        return $imageFilter[0];
    }
    
    
    
    /*
     * 20-10-2014
     * Получение полных данных о странице по id
     * roy
     */
    
    public function getPageById($idPage){
        $params['id_page'] = $idPage;
        $params = $this->validate($params, $rules = array(
                'required' => 'id_page',
                'string' => 'id_page'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        //получаем основные параметры страницы
        $sql = "SELECT * FROM `page` p WHERE p.id_page = '{$params['id_page']}'";
        $result = $this->query($sql);
        if(!empty($result)){
            $result = $result[0];
        }
        
        if(!$result){
            return $this->bdError;
        }
        
        //получаем тип страницы
        $sql = "SELECT * FROM `page_type` pt WHERE pt.id_page_type = '{$result['page_type']}'";
        $pageType = $this->query($sql);
        $result['page_type'] = $pageType[0];
        
        //получаем доп. поля для данного материала
        $sql = "SELECT * FROM `field` f
                INNER JOIN `field_aux` fa ON fa.field_id = f.id_field
                INNER JOIN `field_type` ft ON f.field_type_id = ft.id_field_type
                WHERE fa.page_type_id = '{$result['page_type']['id_page_type']}'";
        $result['page_type']['fields'] = $this->query($sql);
        
        //получаем фильтры для изображений
        foreach ($result['page_type']['fields'] as $key => $value) {
            
            if($value['type'] == 'image' || $value['type'] == 'single_image'){
                $result['page_type']['fields'][$key]['image_filter'] = $this->getImageFilterById($value['image_filter']);
                $result[$value['field_name']] = $this->getAuxFieldImageById($value['field_name'], $result['id_page'], $result['page_type']['fields'][$key]['image_filter']);
                
            }else{
                $result[$value['field_name']] =  $this->getAuxFieldById($value['field_name'], $result['id_page']);
            }
            
        }
        
        return $result;
        
    }
    
   
    public function getAllMaterialForType($idPageType) {
        
        $sql = "SELECT * FROM `page` WHERE `page_type` = '{$idPageType}'";
        $intermediateResult = $this->query($sql);
        
        $result = array();
        
        foreach ($intermediateResult as $key => $value) {
            $result[] = $this->getPageById($value['id_page']);
        }
        
        return $result;
        
    }
    
    
    /*
     * 26-11-2014
     * Получение нижнего меню
     * roy
     */
    
    public function getFooterMenu(){
        
        $sql = "SELECT `id_page`, `title`, `link`, `parent_id` FROM `page` WHERE `parent_id` = 0 ORDER BY `sort`";
        $result = $this->query($sql);
        
        if(empty($result)){
            return false;
        }
        
        foreach ($result as $key => $value) {
            $sqlSecond = "SELECT `id_page`, `title`, `link`, `parent_id` FROM `page` WHERE `parent_id` = '{$value['id_page']}' ORDER BY `sort`";
            $resultInter = $this->query($sqlSecond);
            $result[$key]['inner'] = $resultInter;
        }
        
        return $result;
        
    }
    
    
    
    /*
     * 26-11-2014
     * Проверка, включено ли отображение основных полей материала
     * roy
     */
    
    public function getMainField($idPageType){
        $sql = "SELECT `main_field` FROM `page_type` WHERE `id_page_type` = '{$idPageType}' LIMIT 1";
        return $this->query($sql);
    }
    
    /*
     * 26-11-2014
     * Возвращаем шаблон материала
     * roy
     */
    
    public function getStandartArray($post){
        $result = $post;
        if(empty($result['link'])) $result['link'] = '';
        if(empty($result['text'])) $result['text'] = '';
        if(empty($result['template'])) $result['template'] = '';
        
        return $result;
    }
    
    
    
    /*
     * 27-11-2014
     * Создание правильной ссылки с учётом родителей
     * roy
     */
    
    public static function getLink($page){
        $defender = 0;
        $result = $page['link'];
        
        while(($page['parent_id'])&&($defender < 10)){
            $sql = "SELECT * FROM `page` WHERE `id_page` = '{$page['parent_id']}'";
            $period = databaseClass::queryStatic($sql);
            $page = $period[0];
            $result = $page['link'] . '/' . $result;
            
            $defender++;
        }
        
        return $result;
    }
    
    
    /*
     * 27-11-2014
     * Получаем нужную нам ссылку
     * roy
     */
    
    public function extractLink($params){
        $result = $params[0];
        
        foreach ($params as $key => $value) {
            $sql = "SELECT * FROM `page` WHERE `link` = '{$value}'";
            $period = $this->query($sql);
            if(count($period)){
                $result = $value;
            }else{
                break;
            }
        }
        
        return $result;
        
    }
    
    /*
     * 21-01-2015
     * выдать все развлечения
     * roy
     */
    
    public function getEntertainment(){
        
        $criteria = "`page_type` = 7 ORDER BY `sort` ASC";
        $allEnter = $this->getAll('page', $criteria);
        
        $result = array();
        if(!empty($allEnter)){
            foreach ($allEnter as $key => $value) {
                $result[] = $this->getPageById($value['id_page']);
            }
        }
        
        return $result;
    }
    
    /*
     * 21-01-2015
     * выдать все рестораны
     * roy
     */
    
    public function getRestoraunt(){
        
        $criteria = "`page_type` = 6 ORDER BY `sort` ASC";
        $allEnter = $this->getAll('page', $criteria);
        
        $result = array();
        if(!empty($allEnter)){
            foreach ($allEnter as $key => $value) {
                $result[] = $this->getPageById($value['id_page']);
            }
        }
        
        return $result;
    }
    
    
    /*
     * 21-01-2015
     * получить список якорных брендов
     * roy
     */
    
    public function getArendBrand(){
        
        $criteria = "1 ORDER BY `sort` ASC";
        $presive = $this->getAll('arend_brand', $criteria);
        
        $result = array();
        if(!empty($presive)){
            
            foreach ($presive as $key => $value) {
                $result[] = $this->getPageById($value['id_page']);
            }
            
        }
        
        return $result;
        
    }
    
    
    
}
