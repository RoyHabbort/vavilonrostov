<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminController
 *
 * @author Рой
 */
class adminController extends controllerClass{
    
    
    function __construct() {
        heretic::$_path['template'] = 'template/admin/';
        heretic::$active_page = '';
        heretic::$_config['titlePage'] = 'Административная панель';
        
        heretic::$_hereticMenu = array(
            1 => array(
                'title' => 'Статичные страницы',
                'link' => 'staticPage'
            ),
            2 => array(
                'title' => 'Магазины',
                'link' => 'shop'
            ),
            3 => array(
                'title' => 'Рестораны',
                'link' => 'restoraunt'
            ),
            4 => array(
                'title' => 'Развлечения',
                'link' => 'enter'
            ),
           
            5 => array(
                'title' => 'Промобаннер',
                'link' => 'promo'
            ),
            
            6 => array(
                'title' => 'Новости',
                'link' => 'news'
            ),
            7 => array(
                'title' => 'Акции',
                'link' => 'stock'
            )
        );
    }
    
    
    public function index() {
        
        heretic::$_config['titlePage'] = 'Административная панель';
        if(!empty($_SESSION['rules'])){
            if($_SESSION['rules'] == 4){
                $location = '/admin/staticPage';
                header( "Location: {$location}", true, 303 );
            }
        }
        
        if(!empty($_POST)){
            $admin = new admin();
            $errors = $admin->loginAdmin($_POST);
            if (!$errors){
                $location = '/admin/staticPage';
                header( "Location: {$location}", true, 303 );
            }else{
                $this->partialRender('login', array('errors' => $errors));
                return false;
            }
        }else{
            $this->partialRender('login');
        }

    }
    

    public function logout(){
        session_destroy();
        $location = '/';
        header( "Location: {$location}", true, 303 );
    }
    
    
    private function confirmRules(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
    } 
    
    
    
    /*-----------------------------------------------------------------------------------------------------------------*/
    
    
    /*
     * 30-01-2015
     * Промобаннер
     * roy
     */
    
    
    public function promo(){
        $this->confirmRules();
        
        heretic::$active_page = 5;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`page_type` = 12 ORDER BY `sort` ASC";
        $presive = $admin->getAll('page', $criteria);
        
        $result = array();
        if(!empty($presive)){
            foreach($presive as $key => $value){
                $result[] = $model->getPageById($value['id_page']);
            }
        }
        
        
        $this->render('promo/list', array(
            'result' => $result
        ));
        
    }
    
    
    /*
     * 30-01-2015
     * Добавление слайда
     * roy
     */
    
    public function addPromo(){
        
        $this->confirmRules();
        heretic::$active_page = 5;
     
        $idPageType = 12;
        $admin = new admin();
        $model = new page();
        
        $parent = $this->getParentOption();
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $parentId = $admin->getDefaultParent($idPageType);
        $defaultOptions = $admin->getDefaultOptions($idPageType);
        
        $result = array(
            'parent_id' => $defaultOptions['type_parent_id'],
            'template' => $defaultOptions['default_template']
        );
        
        if(!empty($_POST)){
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType; 
            $post['template'] = $defaultOptions['default_template'];
            $post['parent_id'] = $parentId;
            
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/promo', 'Слайд добавлен.');
            }else{
                $this->render('promo/addPromo', array('main_field' => $mainField, 'result' => $_POST, 'errors' => $result['errors'], 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField)); 
            }
        }else{
            $this->render('promo/addPromo', array('main_field' => $mainField, 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField, 'result' => $result));  
        }
    }
    
    
    
    
    
    /*
     * 30-01-2015
     * Редактирование слайда
     * roy
     */
    
    public function editPromo($params){
        $this->confirmRules();
        heretic::$active_page = 5;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        $shopInfo = $modelMagazine->getShopOnMap($page['id_page']);
        
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            $post['page_type'] = $idPageType;
            $post['link'] = $page['link'];
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/promo', 'Слайд отредактирован');
            }else{
                $this->render('promo/editPromo', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                    'shopInfo' => $shopInfo    
                )); 
            }
        }else{
            $this->render('promo/editPromo', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent,
                'aux_field' => $auxField,
                'shopInfo' => $shopInfo   
            ));  
        }
    }
    
    
    
    
    
    
    
    
    /*-----------------------------------------------------------------------------------------------------------------*/
    
    /*
     * 22-01-2015
     * статические страницы
     * roy
     */
    
    public function staticPage(){
        $this->confirmRules();
        
        heretic::$active_page = 1;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`id_page` = 6 OR `id_page` = 7 OR `id_page` = 179 OR `id_page` = 180 OR `id_page` = 191 ORDER BY `title` ASC";
        $result = $admin->getAll('page', $criteria);
        
        $this->render('static/list', array(
            'result' => $result
        ));
        
    }
    
    
    /*
     * 22-01-2015
     * редактирование статичных страниц
     * roy
     */
         
    public function editStatic($params){
        $this->confirmRules();
        heretic::$active_page = 1;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            $post['page_type'] = $idPageType;
            
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/staticPage', 'Страница отредактирована');
            }else{
                $this->render('static/editStatic', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                )); 
            }
        }else{
            $this->render('static/editStatic', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent,
                'aux_field' => $auxField,
            ));  
        }
    }
    
    
    /*
     * 22-01-2015
     * Добавление якорного арендатора
     * roy
     */
    
    public function addArendBrand($params){
        $this->confirmRules();
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        
        if(empty($_POST)){
            $location = "/admin/editStatic/{$idPage}/{$idPageType}";
            header( "Location: {$location}", true, 303 );
        }
        
        $model = new admin();
        
        $result = $model->addArendBrand($_POST);
        
        if(!empty($result['errors'])){
            heretic::redirect('errors', "/admin/editStatic/{$idPage}/{$idPageType}", $result['errors']);
        }else{
            heretic::redirect('success', "/admin/editStatic/{$idPage}/{$idPageType}", $result['success']);
        }
        
    }
    
    
    /*
     * 22-01-2015
     * Удаление якорных арендаторов
     * roy
     */
    
    public function deleteArendBrand($params){
        $this->confirmRules();
        
        
        $idArendBrand = (integer) $params[0];
        $idPage = (integer) $params[1];
        $idPageType = (integer) $params[2];
        
        $model = new admin();
        
        $resutl = $model->deleteArendBrand($idArendBrand);
        
        if(!empty($result['errors'])){
            heretic::redirect('errors', "/admin/editStatic/{$idPage}/{$idPageType}", $result['errors']);
        }else{
            heretic::redirect('success', "/admin/editStatic/{$idPage}/{$idPageType}", $result['success']);
        }
    }
    
    /*-----------------------------------------------------------------------------------------------------------------*/
    
    /*
     * 19-01-2015
     * Список магазинов
     * roy
     */
    
    public function shop(){
        $this->confirmRules();
        heretic::$active_page = 2;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`page_type` = 3 ORDER BY `title` ASC";
        $result = $admin->getAll('page', $criteria);
        
        $this->render('shop/list', array('result' => $result));
    }
    
    /*
     * 19-01-2015
     * Добавление магазина
     * roy
     */
    
    public function addShop(){
        
        $this->confirmRules();
        heretic::$active_page = 2;
     
        $idPageType = 3;
        $admin = new admin();
        $model = new page();
        
        $parent = $this->getParentOption();
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $parentId = $admin->getDefaultParent($idPageType);
        $defaultOptions = $admin->getDefaultOptions($idPageType);
        
        $result = array(
            'parent_id' => $defaultOptions['type_parent_id'],
            'template' => $defaultOptions['default_template']
        );
        
        if(!empty($_POST)){
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType; 
            $post['template'] = $defaultOptions['default_template'];
            $post['parent_id'] = $parentId;
            
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/shop', 'Магазин добавлен.');
            }else{
                $this->render('shop/addShop', array('main_field' => $mainField, 'result' => $_POST, 'errors' => $result['errors'], 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField)); 
            }
        }else{
            $this->render('shop/addShop', array('main_field' => $mainField, 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField, 'result' => $result));  
        }
    }
    
    
    /*
     * 19-01-2015
     * Редактирование Магазина
     * roy
     */
    
    public function editShop($params){
        $this->confirmRules();
        heretic::$active_page = 2;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        $shopInfo = $modelMagazine->getShopOnMap($page['id_page']);
        
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            $post['page_type'] = $idPageType;
            
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/shop', 'Информация о магазине отредактирована');
            }else{
                $this->render('shop/editShop', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                    'shopInfo' => $shopInfo    
                )); 
            }
        }else{
            $this->render('shop/editShop', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent,
                'aux_field' => $auxField,
                'shopInfo' => $shopInfo   
            ));  
        }
    }
    
    
    /*------------------------------------------------------------------------------------------------------------------------------------------------*/
    
    
            
    /*
     * 19-01-2015
     * Список ресторанов
     * roy
     */
    
    public function restoraunt() {
        
        $this->confirmRules();
        heretic::$active_page = 3;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`page_type` = 6 ORDER BY `title` ASC";
        $result = $admin->getAll('page', $criteria);
        
        $this->render('restoraunt/list', array('result' => $result));
    }
    
    
    
    /*
     * 19-01-2015
     * Добавление ресторана
     * roy
     */
    
    public function addRestoraunt(){
        
        $this->confirmRules();
        heretic::$active_page = 3;
     
        $idPageType = 6;
        $admin = new admin();
        $model = new page();
        
        $parent = $this->getParentOption();
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $parentId = $admin->getDefaultParent($idPageType);
        $defaultOptions = $admin->getDefaultOptions($idPageType);
        
        $result = array(
            'parent_id' => $defaultOptions['type_parent_id'],
            'template' => $defaultOptions['default_template']
        );
        
        if(!empty($_POST)){
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType; 
            $post['template'] = $defaultOptions['default_template'];
            $post['parent_id'] = $parentId;
            
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/restoraunt', 'Ресторан добавлен.');
            }else{
                $this->render('restoraunt/addRestoraunt', array('main_field' => $mainField, 'result' => $_POST, 'errors' => $result['errors'], 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField)); 
            }
        }else{
            $this->render('restoraunt/addRestoraunt', array('main_field' => $mainField, 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField, 'result' => $result));  
        }
    }
    
    
    /*
     * 19-01-2015
     * Редактирование ресторана
     * roy
     */
    
    public function editRestoraunt($params){
        $this->confirmRules();
        heretic::$active_page = 3;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        $shopInfo = $modelMagazine->getShopOnMap($page['id_page']);
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType;
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/restoraunt', 'Информация о ресторане отредактирована');
            }else{
                $this->render('restoraunt/editRestoraunt', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                    'shopInfo' => $shopInfo 
                )); 
            }
        }else{
            $this->render('restoraunt/editRestoraunt', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent, 
                'aux_field' => $auxField,
                'shopInfo' => $shopInfo 
            ));  
        }
    }
    
    
    
    /*--------------------------------------------------------------------------------------------------------------------------------------------*/
    
    
    
    /*
     * 20-01-2015
     * Развлечения
     * roy
     */
            
    /*
     * 20-01-2015
     * вывод списка развлечений
     * roy
     */        
    
    public function enter(){
        
        $this->confirmRules();
        heretic::$active_page = 4;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`page_type` = 7 ORDER BY `title` ASC";
        $result = $admin->getAll('page', $criteria);
        
        $this->render('entertainment/list', array('result' => $result));
    }
    
    
    
    /*
     * 20-01-2015
     * Добавить развлечение
     * roy
     */
    
    public function addEnter(){
        
        $this->confirmRules();
        heretic::$active_page = 3;
     
        $idPageType = 7;
        $admin = new admin();
        $model = new page();
        
        $parent = $this->getParentOption();
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $parentId = $admin->getDefaultParent($idPageType);
        $defaultOptions = $admin->getDefaultOptions($idPageType);
        
        $result = array(
            'parent_id' => $defaultOptions['type_parent_id'],
            'template' => $defaultOptions['default_template']
        );
        
        if(!empty($_POST)){
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType; 
            $post['template'] = $defaultOptions['default_template'];
            $post['parent_id'] = $parentId;
            
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/enter', 'Развлечение добавлено.');
            }else{
                $this->render('entertainment/addEnter', 
                        array(
                            'main_field' => $mainField, 
                            'result' => $_POST, 
                            'errors' => $result['errors'], 
                            'idPageType' => $idPageType, 
                            'parent' => $parent, 
                            'aux_field' => $auxField
                        )); 
            }
        }else{
            $this->render('entertainment/addEnter', 
                    array(
                        'main_field' => $mainField, 
                        'idPageType' => $idPageType, 
                        'parent' => $parent, 
                        'aux_field' => $auxField, 
                        'result' => $result
                    ));  
        }
        
        
    }
    
    
    /*
     * 20-01-2015
     * Редактирование развлечения
     * roy
     */
    
    public function editEnter($params){
        $this->confirmRules();
        heretic::$active_page = 4;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        $shopInfo = $modelMagazine->getShopOnMap($page['id_page']);
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType;
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/enter', 'Информация о развлечении отредактирована');
            }else{
                $this->render('entertainment/editEnter', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                    'shopInfo' => $shopInfo 
                )); 
            }
        }else{
            $this->render('entertainment/editEnter', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent, 
                'aux_field' => $auxField,
                'shopInfo' => $shopInfo 
            ));  
        }
    }
    
    
    /*-------------------------------------------------------------------------------------------------------------------------------------------------*/
    
    
    /*
     * 22-01-2015
     * Вывод новостей
     * roy
     */
    
    public function news(){
        
        $this->confirmRules();
        heretic::$active_page = 6;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`page_type` = 10 ORDER BY `date_create` DESC";
        $result = $admin->getAll('page', $criteria);
        
        $this->render('news/list', array('result' => $result));
        
    }
    
    
    /*
     * 20-01-2015
     * Добавить новость
     * roy
     */
    
    public function addNews(){
        
        $this->confirmRules();
        heretic::$active_page = 6;
     
        $idPageType = 10;
        $admin = new admin();
        $model = new page();
        
        $parent = $this->getParentOption();
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $parentId = $admin->getDefaultParent($idPageType);
        $defaultOptions = $admin->getDefaultOptions($idPageType);
        
        $result = array(
            'parent_id' => $defaultOptions['type_parent_id'],
            'template' => $defaultOptions['default_template']
        );
        
        if(!empty($_POST)){
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType; 
            $post['template'] = $defaultOptions['default_template'];
            $post['parent_id'] = $parentId;
            
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/news', 'Новость добавлена.');
            }else{
                $this->render('news/addNews', 
                        array(
                            'main_field' => $mainField, 
                            'result' => $_POST, 
                            'errors' => $result['errors'], 
                            'idPageType' => $idPageType, 
                            'parent' => $parent, 
                            'aux_field' => $auxField
                        )); 
            }
        }else{
            $this->render('news/addNews', 
                    array(
                        'main_field' => $mainField, 
                        'idPageType' => $idPageType, 
                        'parent' => $parent, 
                        'aux_field' => $auxField, 
                        'result' => $result
                    ));  
        }
        
        
    }
    
    
    
    /*
     * 20-01-2015
     * Редактирование новости
     * roy
     */
    
    public function editNews($params){
        $this->confirmRules();
        heretic::$active_page = 4;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        $shopInfo = $modelMagazine->getShopOnMap($page['id_page']);
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType;
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/news', 'Новость отредактирована');
            }else{
                $this->render('news/editNews', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                    'shopInfo' => $shopInfo 
                )); 
            }
        }else{
            $this->render('news/editNews', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent, 
                'aux_field' => $auxField,
                'shopInfo' => $shopInfo 
            ));  
        }
    }
    
    
    
    /*-------------------------------------------------------------------------------------------------------------------------------------------------*/
    
    
    /*
     * 22-01-2015
     * Вывод акций
     * roy
     */
    
    public function stock(){
        
        $this->confirmRules();
        heretic::$active_page = 7;
        
        $admin = new admin();
        $model = new page();
        
        $criteria = "`page_type` = 11 ORDER BY `date_create` DESC";
        $presive = $admin->getAll('page', $criteria);
        
        $result = array();
        if(!empty($presive)){
            foreach($presive as $key => $value){
                $result[] = $model->getPageById($value['id_page']);
            }
        }
        
        
        $this->render('stock/list', array('result' => $result));
        
    }
    
    
    /*
     * 20-01-2015
     * Добавить акцию
     * roy
     */
    
    public function addStock(){
        
        $this->confirmRules();
        heretic::$active_page = 7;
     
        $idPageType = 11;
        $admin = new admin();
        $model = new page();
        
        $parent = $this->getParentOption();
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $parentId = $admin->getDefaultParent($idPageType);
        $defaultOptions = $admin->getDefaultOptions($idPageType);
        
        $result = array(
            'parent_id' => $defaultOptions['type_parent_id'],
            'template' => $defaultOptions['default_template']
        );
        
        if(!empty($_POST)){
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType; 
            $post['template'] = $defaultOptions['default_template'];
            $post['parent_id'] = $parentId;
            
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/stock', 'Акция добавлена.');
            }else{
                $this->render('stock/addStock', 
                        array(
                            'main_field' => $mainField, 
                            'result' => $_POST, 
                            'errors' => $result['errors'], 
                            'idPageType' => $idPageType, 
                            'parent' => $parent, 
                            'aux_field' => $auxField
                        )); 
            }
        }else{
            $this->render('stock/addStock', 
                    array(
                        'main_field' => $mainField, 
                        'idPageType' => $idPageType, 
                        'parent' => $parent, 
                        'aux_field' => $auxField, 
                        'result' => $result
                    ));  
        }
        
        
    }
    
    
    
    /*
     * 27-01-2015
     * Редактирование акции
     * roy
     */
    
    public function editStock($params){
        $this->confirmRules();
        heretic::$active_page = 11;
        if(empty($params[0])||empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $idPage = (integer) $params[0];
        $idPageType = (integer) $params[1];
        $admin = new admin();
        $model = new page();
        $page = $admin->getById('page', $idPage);
        $parent = $this->getParentOption($idPage);
        $mainField = $model->getMainField($idPageType);
        $auxField = $admin->getAuxField($idPageType);
        $auxFieldValue = $admin->getFieldValue($idPage, $idPageType);
        
        $modelMagazine = new magazine();
        $shopInfo = $modelMagazine->getShopOnMap($page['id_page']);
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            
            $post['page_type'] = $idPageType;
            $post['template'] = $page['template'];
            $post['sort'] = $page['sort'];
            $post['parent_id'] = $page['parent_id'];
            
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/admin/stock', 'Акция отредактирована');
            }else{
                $this->render('stock/editStock', array(
                    'main_field' => $mainField,
                    'result' => $page,
                    'errors' => $result['errors'],
                    'parent' => $parent,
                    'aux_field' => $auxField,
                    'shopInfo' => $shopInfo 
                )); 
            }
        }else{
            $this->render('stock/editStock', array(
                'main_field' => $mainField,
                'result' => $page,
                'parent' => $parent, 
                'aux_field' => $auxField,
                'shopInfo' => $shopInfo 
            ));  
        }
    }
    
    
    
    
    /*-------------------------------------------------------------------------------------------------------------------------------------------------*/
    
    
    
    
    /*
     * 20-01-2015
     * Отмечаем на карте
     * roy
     */
    
    public function setShopOnMap(){
        $this->confirmRules();
        $admin = new admin();
        
        if(!empty($_POST)){
            $result = $admin->setShopOnMap($_POST);
            
            if(!empty($result['errors'])){
                echo json_encode(array('errors' => 'Произошла ошибка! Попробуйте обновить страницу.'));
                heretic::setFlash('errors', 'Произошла ошибка! Попробуйте обновить страницу.');
            }else{
                echo json_encode(array('success' => 'Объект отмечен на карте.'));
                heretic::setFlash('success', 'Объект отмечен на карте.');
            }
            
        }else{
            echo json_encode(array('errors' => 'Произошла ошибка! Попробуйте обновить страницу.'));
            heretic::setFlash('errors', 'Произошла ошибка! Попробуйте обновить страницу.');
        }
        
        //$admin->setShopOnMap();
        
    }
    
    
    /*
     * 19-01-2015
     * Функция удаления
     * roy
     */
    
    public function delete($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
            exit;
        }
        
        $admin = new admin();
        $idPage = (integer) $params[0];
        $page = (string) $params[1];
        
        $result = $admin->deletePage($idPage);
        
        if(empty($result['errors'])){
            heretic::redirect('success', '/admin/' . $page, 'Запись удалёна');
        }else{
            heretic::redirect('errors', '/admin/' . $page, 'Удалить запись не удалось');
        }
    }

    
    /*
     * 13-10-2014
     * Материалы сайта
     * roy
     */
    
    private function getParentOption($nowPage = '0'){
        
        $admin = new admin();
        $criteria = "1 ORDER BY `page_type` ASC, `sort` ASC";
        $allPage = $admin->getAll('page', $criteria);
        
        $parent['0'] = 'Главная';
        if(is_array($allPage)){
            foreach ($allPage as $key => $value) {
                if($value['id_page'] != $nowPage){
                    $parent[$value['id_page']] = $value['title']; 
                }
            }
        }
        return $parent;
        
    }
    
    
    
}
