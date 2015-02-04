<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of administrationController
 *
 * @author Рой
 */
class hereticController extends controllerClass {
    
    function __construct() {
        heretic::$_path['template'] = 'template/heretic/';
        
        heretic::$_hereticMenu = array(
            1 => array(
                'title' => 'Материалы',
                'link' => 'page'
            ),
            2 => array(
                'title' => 'Типы материалов',
                'link' => 'pageType'
            ),
            3 => array(
                'title' => 'Блоки',
                'link' => 'block'
            ),
            4 => array(
                'title' => 'Поля',
                'link' => 'field'
            ),
            5 => array(
                'title' => 'Фильтры изображения',
                'link' => 'imageFilter'
            ),
            6 => array(
                'title' => 'Настройки',
                'link' => 'options'
            )
        );
        
    }
    
    
    public function index() {
        
        heretic::$_config['titlePage'] = 'Панель разработчика';
        if(!empty($_SESSION['rules'])){
            if($_SESSION['rules'] == 4){
                $location = '/heretic/page';
                header( "Location: {$location}", true, 303 );
            }
        }
        
        if(!empty($_POST)){
            $admin = new admin();
            $errors = $admin->loginAdmin($_POST);
            if (!$errors){
                $location = '/heretic/page';
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
    
    
    /*
     * 13-10-2014
     * Универсальная функция удаления
     * roy
     */
    
    public function delete($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idPageType = (integer) $params[0];
        
        
        $admin = new admin();
        if(!empty($_POST['delete'])){
            $table = $_POST['delete'];
            $result = $admin->DeleteById($table, $idPageType);
            $page = $_POST['page'];
            $text = $_POST['text'];
            if($result){
                heretic::redirect('success', '/heretic/' . $page, $text .' удалён');
            }else{
                heretic::redirect('error', '/heretic/edit' .$page . '/' . $idPageType, $text . ' удалить не удалось');
            }
        }else{
            errorClass::getPageError(404);
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
    
    
    /*
     * 11-2014
     * Список материалов
     * roy
     */
    
    public function page(){
        $this->confirmRules();
        $admin = new admin();
        $model = new page();
        $criteria = "1 ORDER BY  `sort` ASC";
        $result = $admin->getAll('page_type', $criteria);
        if(is_array($result)){
            foreach ($result as $key => $value){
                $criteria = "`page_type` = '{$value['id_page_type']}' ORDER BY `sort` ASC";
                $result[$key]['page'] = $admin->getAll('page', $criteria);
                
            }
        }
        
        if(is_array($result)){
           foreach ($result as $key => $value) {
                if(is_array($result[$key]['page'])){
                    foreach($result[$key]['page'] as $key2 => $value2){
                        $result[$key]['page'][$key2] = $model->getPageByLink($value2['link']);
                        if($value2['page_type'] == 3){
                            $result[$key]['page'][$key2]['parent'] = $model->getCategoryMagazin($value2['id_page']);
                        }else{
                            $result[$key]['page'][$key2]['parent'] = $model->getParentName($value2['parent_id']);
                        }
                        
                    }
                }
            } 
        }
        
        $this->render('page/page', array('result' => $result));
    }
    
    
    /*
     * 11-2014
     * создание материала
     * roy
     */
    
    public function addPage($params){
        
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idPageType = (integer) $params[0];
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
            $result = $admin->addPage($post, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/page', 'Добавлен материал');
            }else{
                $this->render('page/addPage', array('main_field' => $mainField, 'result' => $_POST, 'errors' => $result['errors'], 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField)); 
            }
        }else{
            $this->render('page/addPage', array('main_field' => $mainField, 'idPageType' => $idPageType, 'parent' => $parent, 'aux_field' => $auxField, 'result' => $result));  
        }
    }
    
    /*
     * 11-2014
     * Редактирование материала
     * roy
     */
    
    public function editPage($params){
        $this->confirmRules();
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
        
        foreach ($auxFieldValue as $key => $value) {
            $page[$key] = $value;
        }
        
        if(!empty($_POST)){
            
            $post = $_POST;
            $post = $model->getStandartArray($post);
            $post['page_type'] = $idPageType;
            $result = $admin->editPage($post, $idPage, $auxField);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/page', 'Материал отредактирован');
            }else{
                $this->render('page/editPage', array('main_field' => $mainField, 'result' => $page, 'errors' => $result['errors'], 'parent' => $parent, 'aux_field' => $auxField)); 
            }
        }else{
            $this->render('page/editPage', array('main_field' => $mainField, 'result' => $page, 'parent' => $parent, 'aux_field' => $auxField));  
        }
    }
    
    
    public function deletePage($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        
        $admin = new admin();
        $idPage = (integer) $params[0];
        
        $result = $admin->deletePage($idPage);
        
        if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/page/', 'Материал удалён');
        }else{
            heretic::redirect('errors', '/heretic/editPage/' . $idPage, 'Произошла ошибка. Удалить материал не удалось');
        }
    }
    
    
    
    
    /*
     * 13-10-2014
     * Page Type 
     * roy
     */
    
    private function getAuxField($field){
        
        if(empty($field)){
            $field['id_field'] = '___';
        }
        
        $admin = new admin();
        $criteria = ' 1 ORDER BY `id_field` ASC';
        $fieldAll = $admin->getAll('field', $criteria);
        $auxField = '';
        
        if (!empty($fieldAll)){
            foreach ($fieldAll as $key => $value) {
                foreach ($field as $key2 => $value2) {
                    if($value2['id_field'] == $value['id_field']){
                        unset($fieldAll[$key]);
                    }
                }
            }

            foreach ($fieldAll as $key => $value) {
                $auxField[$value['id_field']] = $value['title'];
            }
        }
        
        return $auxField;
    }
    
    
    public function pageType(){
        $this->confirmRules();
        $admin = new admin();
        $criteria = "1 ORDER BY `sort` ASC";
        $result = $admin->getAll('page_type', $criteria);
        $this->render('pageType/pageType', array('result' => $result));
    }
    
    
    
    public function addPageType(){
        $this->confirmRules();
        $admin = new admin();
        
        $parent = $this->getParentOption();

        if(!empty($_POST)){
            $result = $admin->AddInTable('page_type', $_POST, $rules = array(
                    'required' => 'title',
                    'string' => 'title, sort, type_parent_id, default_template'
                ));
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/pageType', 'Добавлен тип материала');
            }else{
                $this->render('pageType/addPageType', array('result' => $_POST, 'errors' => $result['errors'], 'parent' => $parent)); 
            }
        }else{
            $this->render('pageType/addPageType', array('parent' => $parent));  
        }
        
        
    }  
    
    
    public function editPageType($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        
        $idPageType = (integer) $params[0];
        $admin = new admin();
        $pageType = $admin->getById('page_type', $idPageType);
        $field = $admin->getField($idPageType);
        
        $parent = $this->getParentOption();
        
        $auxField = $this->getAuxField($field);
        if(!empty($_POST)){
            
            $post = $_POST;
            
            if(empty($post['main_field'])){
                $post['main_field'] = 0;
            }
            if($post['main_field'] === 'on') {
                $post['main_field'] = 1;
            }
            
            $result = $admin->editById('page_type', $post, $rules = array(
                'required' => 'title',
                'string' => 'title, sort, type_parent_id, default_template'
                ), $idPageType);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/pageType', 'Тип материала отредактирован');
            }else{
                $this->render('pageType/editPageType', array('result' => $pageType, 'errors' => $result['errors'], 'aux_field' => $auxField, 'field' => $field, 'parent' => $parent)); 
            }
        }else{
            $this->render('pageType/editPageType', array('result' => $pageType, 'aux_field' => $auxField, 'field' => $field, 'parent' => $parent)); 
        }
        
    }
    
    public function deletePageType($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idPageType = (integer) $params[0];
        $admin = new admin();
        if(!empty($_POST['delete'])){
            $result = $admin->deletePageType($idPageType);
            if($result){
                heretic::redirect('success', '/heretic/pageType', 'Тип материала удалён');
            }else{
                heretic::redirect('error', '/heretic/editPageType/' . $idPageType, 'Удалить тип материала не удалось');
            }
        }else{
            errorClass::getPageError(404);
        }
    }
    
    
    /*
     * 10-2014
     * Добавить дополнительное поле
     * roy
     */
    
    public function addAuxField($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        
        $idPageType = (integer) $params[0];
        $admin = new admin();
        
        if(!empty($_POST)){
            $post['field_id'] = $_POST['field_id'];
            $post['page_type_id'] = $idPageType;
            $result = $admin->AddInTable('field_aux', $post, $rules = array(
                    'required' => 'field_id, page_type_id',
                    'string' => 'field_id, page_type_id'
                    ));
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/editPageType/' . $idPageType, 'Поле добавлено');
            }else{
                heretic::redirect('errors', '/heretic/editPageType/' . $idPageType, 'Произошла ошибка. Поле не добавлено');
            }
            
        }else{
            errorClass::getPageError(404);
        }
    }
    
    public function deleteAuxField($params){
        $this->confirmRules();
        if(empty($params[0]) || empty($params[1])){
            errorClass::getPageError(404);
        }
        
        $admin = new admin();
        $idPageType = (integer) $params[0];
        $idField = (integer) $params[1];
        
        $result = $admin->deleteAuxField($idField, $idPageType);
        
        if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/editPageType/' . $idPageType, 'Поле удалено');
        }else{
            heretic::redirect('errors', '/heretic/editPageType/' . $idPageType, 'Произошла ошибка. Поле не удалено');
        }
        
    }


    /*
     * 13-10-2014
     * Редактирование блоков
     * roy
     */
    
    public function block(){
        $this->confirmRules();
        $this->render('block/block');
    }
    
    public function topMenu(){
        $this->confirmRules();
        
        $admin = new admin();
        $criteria = '1 ORDER BY `sort` ASC';
        $options = $admin->getAll('page_type', $criteria);;
        
        
        
        $opt = array();
        foreach ($options as $key => $value) {
            $opt[$value['id_page_type']] = $value['title']; 
        }
        $options = $opt;
        
        if(!empty($_POST)){
            $result = $admin->editTopMenu($_POST);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/block', 'Блок верхнего меню отредактирован');
            }else{
                $this->render('block/topMenu/topMenu', array('options' => $options, 'result' => $_POST, 'errors' => $result['errors']));
            }
        }else{
            $this->render('block/topMenu/topMenu', array('options' => $options));
        }
        
        
    }
    
    
    
    /*
     * 14-10-2014
     * Дополнительные поля
     * roy
     */
    
    private function getFieldType(){
        $admin = new admin();
        $type = $admin->getAll('field_type');
        $fieldType = '';
        if(!empty($type)){
            foreach($type as $key => $value){
                $fieldType[$value['id_field_type']] = $value['type_name'];
            }
        }
        return $fieldType;
    }
    
    public function field(){
        $this->confirmRules();
        $admin = new admin();
        $result = $admin->getAll('field');
        $this->render('field/field', array('result' => $result));
    }
    
    
    public function addField(){
        $this->confirmRules();
        $admin = new admin();
        $fieldType = $this->getFieldType();
        $imageFilter = $admin->getFilterArray();
        $pageType = $admin->getPageTypeSelect();
        
        if(!empty($_POST)){
            $result = $admin->addField($_POST);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/field', 'Дополнительное поле создано');
            }else{
                $this->render('field/addField', array('result' => $_POST, 'errors' => $result['errors'], 'field_type' => $fieldType, 'image_filter' => $imageFilter, 'page_type' => $pageType));
            }
        }else{
            $this->render('field/addField', array('field_type' => $fieldType, 'image_filter' => $imageFilter, 'page_type' => $pageType));
        }
    }
    
    public function editField($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        
        $admin = new admin();
        $idField = (integer) $params[0];
        $field = $admin->getById('field', $idField);
        $fieldType = $this->getFieldType();
        if(!empty($_POST)){
            $result = $admin->editField($_POST, $idField);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/field', 'Дополнительное поле отредактированно');
            }else{
                $this->render('field/editField', array('result' => $_POST, 'errors' => $result['errors'], 'field_type' => $fieldType));
            }
        }else{
            $this->render('field/editField', array('result' => $field ,'field_type' => $fieldType));
        }
    }
    
    
    public function deleteField($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $admin = new admin();
        $idField = (integer) $params[0];
        if(!empty($_POST['delete'])){
            $result = $admin->deleteField($idField);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/field', 'Дополнительное поле было удалено');
            }else{
                heretic::redirect('errors', '/heretic/editField/' . $idField, 'При удалении произошла ошибка. Проверте БД.');
            }
        }else{
            errorClass::getPageError(404);
        }
    }
    
    
    /*
     * 15-10-2014
     * Фильтры изображений
     * roy
     */
    
    public function imageFilter(){
        $this->confirmRules();
        $admin = new admin();
        $criteria = "1 ORDER BY `sort` ASC";
        $imageFilter = $admin->getAll('image_filter', $criteria);
        
        $this->render('imageFilter/imageFilter', array('result' => $imageFilter));
    }
    
    
    public function addImageFilter(){
        $this->confirmRules();
        $admin = new admin();
        $cropType = $admin->optionCropType();
        
        if(!empty($_POST)){
            $result = $admin->addImageFilter($_POST);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/imageFilter', 'Фильтр создан');
            }else{
                $this->render('imageFilter/addImageFilter', array('result' => $_POST, 'errors' => $result['errors'], 'crop_type' => $cropType));
            }
        }else{
            $this->render('imageFilter/addImageFilter', array('crop_type' => $cropType));
        }
        
    }
    
    
    public function editImageFilter($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idImageFilter = (integer) $params[0];
        $admin = new admin();
        $cropType = $admin->optionCropType();
        $imageFilter = $admin->getImageFilterById($idImageFilter);
        
        if(!empty($_POST)){
            $result = $admin->editImageFilter($_POST, $idImageFilter);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/imageFilter', 'Фильтр отредактирован');
            }else{
                $this->render('imageFilter/editImageFilter', array('result' =>$_POST, 'errors' => $result['errors'], 'crop_type' => $cropType));
            }
        }else{
            $this->render('imageFilter/editImageFilter', array('result' => $imageFilter, 'crop_type' => $cropType));
        }
        
    }
    
    
    public function deleteImageFilter($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idImageFilter = (integer) $params[0];
        $admin = new admin();
        if(!empty($_POST['delete'])){
            $result = $admin->deleteImageFilter($idImageFilter);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/imageFilter', 'Фильтр был удалён');
            }else{
                heretic::redirect('errors', '/heretic/editImageFilter/' . $idImageFilter, 'При удалении произошла ошибка. Проверте БД.');
            }
        }else{
            errorClass::getPageError(404);
        }
    }
    
    
    
    /*
     * 22-10-2014
     * Слайдер
     * Roy
     */
            
    public function slider(){
        $this->confirmRules();
        
        $admin = new admin();
        $criteria = "1 ORDER BY `sort` ASC";
        $slider = $admin->getAll('slider', $criteria);
        
        $this->render('block/slider/slider', array('result' => $slider));
        
    }
    
    
    public function addSlider(){
        $this->confirmRules();
        
        $admin = new admin();
        
        if(!empty($_POST)){
            
            $result = $admin->addSlide($_POST);
            
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/slider', 'Слайд добавлен');
            }else{
                $this->render('block/slider/addSlider', array('result' => $_POST, 'errors' => $result['errors']));
            }
            
        }else{
            $this->render('block/slider/addSlider', array());
        }
        
    }
    
    
    public function editSlider($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idSlider = (integer) $params[0];
        $admin = new admin();
        $slider = $admin->getById('slider', $idSlider);
        if(!empty($_POST)){
            $result = $admin->editSlider($_POST, $idSlider);
            if(empty($result['errors'])){
                heretic::redirect('success', '/heretic/slider', 'Слайд изменён');
            }else{
                $this->render('block/slider/editSlider', array('result' => $slider, 'errors' => $result['errors']));
            }
        }else{
            $this->render('block/slider/editSlider', array('result' => $slider));
        }
    }
    
    
    /*
     * 22-10-2014
     * Удалить элемент слайда
     * roy
     */
    
    public function deleteSlider($params){
        $this->confirmRules();
        if(empty($params[0])){
            errorClass::getPageError(404);
        }
        $idSlider = (integer) $params[0];
        $admin = new admin();
        if(!empty($_POST['delete'])){
            $result = $admin->DeleteById('slider', $idSlider);
            if($result){
                heretic::redirect('success', '/heretic/slider', 'Слайд удалён');
            }else{
                heretic::redirect('error', '/heretic/editSlider/' . $idSlider, 'Слайд удалить не удалось');
            }
        }else{
            errorClass::getPageError(404);
        }
    }
    
    
    
    
    /*
     * 23-11-2014
     * Review
     * roy
     */
    
    
    public function review(){
        $this->confirmRules();
        
        $model = new review();
        $criteria = "1 ORDER BY `moderation` ASC, `date` ASC";
        $reviews = $model->getAll('reviews', $criteria);
        
        foreach ($reviews as $key => $value) {
            if($value['moderation'] == 0){
                $result['moder'][] = $value;
            }elseif($value['moderation'] == 1){
                $result['success'][] = $value;
            }
        }
        
        $this->render('block/review/review', array('result' => $result));
        
    }
    
    
    /*
     * 23-11-2014
     * Подтверждение модерации отзыва
     * roy
     */
    
    public function reviewSuccess($params){
        $this->confirmRules();
        
        if(empty($params[0])){
            errorClass::getPageError(404);
            exit;
        }
        
        $model = new review();
        $idReview = (integer) $params[0];

        $result = $model->reviewSuccess($idReview);
        
        if(empty($result['errors'])){
            heretic::redirect('success', '/heretic/review', 'Отзыв успешно одобрен');
        }else{
            heretic::redirect('error', '/heretic/review', 'Отзыв одобрить не удалось');
        }
        
    }
    
    
    /*
     * 23-11-2014
     * Удалить запись
     * roy
     */
    
    public function deleteItems($params){
        $this->confirmRules();
        
        if(empty($params[0]) || empty($params[1]) ){
            errorClass::getPageError(404);
            exit;
        }
        
        $model = new admin();
        $table = (string) mysql_real_escape_string($params[0]);
        $idItems = (integer) $params[1];
        $redirect = (string) $params[2];
        
        $result =  $model->DeleteById($table, $idItems);
        
        if($result){
            heretic::redirect('success', '/heretic/' . $redirect, 'Удаление прошло успешно');
        }else{
            heretic::redirect('error', '/hereitc/' . $redirect, 'Удалить не удалось');
        }
        
    }
    
    
}
