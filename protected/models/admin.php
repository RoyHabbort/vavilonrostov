<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Рой
 */
class admin extends modelsClass {
    
    private $bdError = array('errors' => array('mysql_error' => 'Ошибка БД')); 
    
    /*
     * 13-10-2014
     * Проверка входа в админку
     * roy
     */
    
    public function loginAdmin($params){
        
        $params = $this->validate($params, array(
           'string' => 'login, password', 
        ));
        $password = md5($params['password']);
        $sql = "SELECT * FROM `user` WHERE `rules` = 4 AND `login` = '{$params['login']}' AND `password` = '{$password}'";
        $result = $this->query($sql);
        
        if($result){
            $_SESSION['login'] = $params['login'];
            $_SESSION['rules'] = 4;
            $_SESSION['user_id'] = $result[0]['id_user'];
            return $params['error'] = false;
        }else{
            $params['error'] = "Неверная пара логин - пароль.";
            return $params['error'];
        }
        
    }
    
    
    /*
     * 13-10-2014
     * Редактирование верхнего меню
     * roy
     */
    
    public function editTopMenu($params){
        $params = $this->validate($params, $rules = array(
            'required' => 'page_type',
            'string' => 'page_type'
            ));
        
        if(empty($params['valid_errors'])){
            $this->query($sql);
            $sql = "UPDATE `top_menu` SET `page_type` = '{$params['page_type']}' WHERE `id_top_menu` = 1";
            $result = $this->query($sql);
            if($result){
                return true;
            }else{
                return $this->bdError;
            }
            
        }else{
            return array('errors' => $params['valid_errors']);
        }
    }
    
    
    /*
     * 14-10-2014
     * Добавление полей
     * roy
     */
    
    
    public function addField($params){
        $params = $this->validate($params, $rules = array(
                'required' => 'title, field_name, field_type_id',
                'string' => 'title, field_name, field_type_id, image_filter, selecter-filter, selecter_list'
                ));
        
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        if( !($params['field_type_id'] == 6 || $params['field_type_id'] == 9) ){
            $params['image_filter'] = '';
        }
        
        if($params['field_type_id'] != 7){
            $params['selecter-filter'] = -1;
        }
        
        //Селектор перечесления
        if($params['selecter-filter'] == 0){
            $params['selecter_list'] = explode(';', $params['selecter_list']);
            
            $params['selecter-filter'] = serialize($params['selecter_list']);
            
        }else{
            $params['selecter-filter'] = serialize($params['selecter-filter']);
        }
        
        
        $sql = "INSERT INTO `field` (`title`, `field_name`, `field_type_id`, `image_filter`, `selecter_filter`) VALUE ('{$params['title']}', '{$params['field_name']}','{$params['field_type_id']}', '{$params['image_filter']}', '{$params['selecter-filter']}' )";
        $result = $this->query($sql);
        if(!$result){
            return $this->bdError;
        }
        $lastId = $this->last_insert_id();
        
        $type = $this->getById('field_type', $params['field_type_id']);
        $innerType = '';
        switch ($type['type']) {
            case 'string': $innerType ='varchar(255)'; break;
            case 'number': $innerType = 'int (11)'; break;
            case 'text': $innerType = 'text'; break;
            case 'date': $innerType = 'DATETIME'; break;
            case 'image': $innerType = 'varchar(255)'; break;
            case 'selecter': $innerType = 'varchar (255)'; break;
            case 'single_image': $innerType = 'varchar(255)'; break;
            default: $innerType ='varchar(255)'; break;
        }
        
        $sql2 = "CREATE TABLE field_inner_{$params['field_name']} (
                id_field_{$params['field_name']} int (11) AUTO_INCREMENT,
                page_id_{$params['field_name']} int (11) NOT NULL,
                field_content_{$params['field_name']} {$innerType},
                PRIMARY KEY (id_field_{$params['field_name']})
             );";
        
        $result2 = $this->query($sql2);        
        
        
        if(!$result2){
            
            $sql3 = "DELETE FROM `field` WHERE `id_field` = '$lastId'";
            $this->query($sql3);
            
            return $this->bdError;
            
        }
        
        return true;
        
    }
    
    
    /*
     * 14-10-2014
     * Редактирование полей
     * roy
     */
    
    public function editField($params, $idField){
        $params['id_field'] = $idField;
        $params = $this->validate($params, $rules = array(
                'required' => 'title, id_field',
                'string' => 'title, id_field'
                ));
        
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "UPDATE `field` SET `title` = '{$params['title']}' WHERE `id_field` = '{$params['id_field']}'";
        $result = $this->query($sql);
        if(!$result){
            return $this->bdError;
        }
        return true;
    }
    
    /*
     * 14-10-2014
     * Удаление полей
     * roy
     */
    public function deleteField($idField){
        $params['id_field'] = $idField;
        $params = $this->validate($params, $rules = array(
                'required' => 'id_field',
                'string' => 'id_field'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql_pre = "SELECT `field_name` FROM `field` WHERE `id_field` = '{$params['id_field']}' LIMIT 1";
        $fieldName = $this->query($sql_pre);
        
        
        $sql = "DELETE FROM `field` WHERE `id_field` = '{$params['id_field']}'";
        $result = $this->query($sql);
        if(!$result){
            return $this->bdError;
        }
        
        $sql2 = "DELETE FROM `field_aux` WHERE `field_id` = '{$params['id_field']}'";
        $result2 = $this->query($sql);
        if(!$result){
            return $this->bdError;
        }
        
        $sql3 = "DROP TABLE field_inner_{$fieldName}";
        $result3 = $this->query($sql3);
        if(!$result){
            return $this->bdError;
        }
        
        return true;
        
    }
    
    
    /*
     * 14-10-2014
     * Выборка всех привязанных за материалом полей
     * roy
     */
    
    public function getField($idPageType){
        $params['id_page_type'] = $idPageType;
        $params = $this->validate($params, $rules = array(
                'required' => 'id_page_type',
                'string' => 'id_page_type'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "SELECT * FROM `field` f 
                INNER JOIN `field_aux` a ON f.id_field = a.field_id
                INNER JOIN `field_type` t ON f.field_type_id = t.id_field_type
                WHERE a.page_type_id = '{$params['id_page_type']}'";
        $result = $this->query($sql);        
        
        if(!$result){
            return false;
        }
        
        return $result;
        
    }
    
    /*
     * 14-10-2014
     * Удаление связки поля и типа материала
     * roy
     */
    
    public function deleteAuxField($idField, $idPageType){
        $params['field_id'] = $idField;
        $params['page_type_id'] = $idPageType;
        $params = $this->validate($params, $rules = array(
                'required' => 'field_id, page_type_id',
                'string' => 'field_id, page_type_id'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "DELETE FROM `field_aux` WHERE `field_id` = '{$params['field_id']}' AND `page_type_id` = '{$params['page_type_id']}'";
        $result = $this->query($sql);
        
        if(!$result){
            return $this->bdError;
        }
        
        return true;
    }
    
    
    /*
     * 14-10-2014
     * Выдать все поля страницы
     * roy
     */
    
    public function getAuxField($idPageType){
        $params['id_page_type'] = $idPageType;
        $params = $this->validate($params, $rules = array(
                'required' => 'id_page_type',
                'string' => 'id_page_type'
                ));
        
        if(!empty($params['valid_errors'])){
            return false;
        }
        
        /*
        $sql = "SELECT * FROM `field` f
                INNER JOIN `field_aux` a ON a.field_id = f.id_field
                INNER JOIN `page_type` pt ON pt.id_page_type = a.page_type_id
                INNER JOIN `page` p ON p.page_type = pt_id_page_type
                WHERE p.id_page = '{$params['id_page']}'";
         * 
         * 
         */
        
        $sql = "SELECT * FROM `field` f
                INNER JOIN `field_aux` a ON a.field_id = f.id_field
                INNER JOIN `field_type` t ON t.id_field_type = f.field_type_id
                WHERE a.page_type_id = '{$params['id_page_type']}' ORDER BY `sort` ASC";
        $result = $this->query($sql);
        
        if(!$result){
            return false;
        }
        
        return $result;
        
    }
    
    
    /*
     * 15-10-2014
     * Получение всех значений полей
     * Roy
     */
    
    public function getFieldValue($idPage, $idPageType = 0){
        $params['id_page'] = $idPage;
        $params['id_page_type'] = $idPageType;
        
        $params = $this->validate($params, $rules = array(
            'required' => 'id_page',
            'string' => 'id_page, id_page_type'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        if(empty($params['id_page_type'])){
            $sql = "SELECT `page_type` FROM `page` WHERE `id_page` = '{$params['id_page']}' LIMIT 1";
            $params['id_page_type'] = $this->query($sql);
            
            if(!$params['id_page_type']){
                return $this->bdError;
            }
        }
        
        $auxField = $this->getAuxField($params['id_page_type']);
        $result = array();  
        
        if($auxField){
            foreach ($auxField as $key => $value) {
                $condit = $this->confirmImage($value['field_name']);
                if($condit){
                    $sql = "SELECT `field_content_{$value['field_name']}`, `id_field_{$value['field_name']}`
                            FROM `field_inner_{$value['field_name']}` WHERE `page_id_{$value['field_name']}` = '{$params['id_page']}'
                            ORDER BY `page_id_{$value['field_name']}` ASC, `id_field_{$value['field_name']}` ASC";
                            
                    $array = $this->query($sql);
                    
                    $resultArray = array();
                    foreach ($array as $key2 => $value2) {
                        $resultArray[$key2]['id'] = $value2['id_field_' . $value['field_name']];
                        $resultArray[$key2]['content'] = $value2['field_content_' . $value['field_name']];
                    }

                    $result['field_inner_'.$value['field_name']]['result']= $resultArray;
                    $result['field_inner_'.$value['field_name']]['option'] = $value;
                }else{
                    $sql = "SELECT `field_content_{$value['field_name']}` FROM `field_inner_{$value['field_name']}` WHERE `page_id_{$value['field_name']}` = '{$params['id_page']}' LIMIT 1";
                    $result['field_inner_'.$value['field_name']] = $this->query($sql);
                }
            }
        }
        
        return $result;
        
    }
    
    
    /*
     * 15-10-2014
     * Правила валидации доп полей
     * roy
     */
    
    private function auxValidate($auxField){
        
        $result = array('string' => '', 'number' => '', 'text' => '');
        
        if(is_array($auxField)){
            foreach ($auxField as $key => $value) {

                switch ($value['type']) {
                    case 'string':
                        $result['string'] .= ', field_inner_' . $value['field_name'];
                        break;
                    case 'number':
                        $result['number'] .= ', field_inner_' . $value['field_name'];
                        break;
                    case 'text':
                        $result['text'] .= ', field_inner_' . $value['field_name'];
                        break;
                    case 'image':

                        break;

                    default:
                        $result['string'] .= ', field_inner_' . $value['field_name'];
                        break;
                }
            }
        }
        
        
        return $result;
        
    }
    
    
    /*
     * 17-10-2014
     * Проверка поля на изображение
     * roy
     */
    
    public function confirmImage($fieldName){
        
        
        $sqlFieldType = "SELECT ft.type FROM `field_type` ft 
                        INNER JOIN `field` f ON f.field_type_id = ft.id_field_type
                        WHERE f.field_name = '{$fieldName}' LIMIT 1";
            
        $fieldType = $this->query($sqlFieldType);
        
        if($fieldType == 'image'){
            return true;
        }else{
            return false;
        }
    }


    /*
     * 14-10-2014
     * Добавление материала
     * roy
     */
    
    public function addPage($params, $auxField){
        
        // Валидация данных
        if(!empty($auxField)){
            $auxValidate = $this->auxValidate($auxField);
        }else{
            $auxValidate['string'] = '';
            $auxValidate['number'] = '';
            $auxValidate['text'] = '';
        }
        
        $params = $this->validate($params, $rules = array(
                    'required' => 'title, page_type',
                    'string' => 'title, link, sort, page_type, parent_id, template' . $auxValidate['string'],
                    'number' => '' . $auxValidate['number'],
                    'text' => 'text' . $auxValidate['text']
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        //если link пустое, то использовать транслит
        if(empty($params['link'])) $params['link'] = $this->toTranslite($params['title']);
        
        //если sort пустое, добавляем элемент в конец
        if(empty($params['sort'])){
            $sql = "SELECT MAX(`sort`) FROM `page` WHERE `page_type` = {$params['page_type']} LIMIT 1";
            $params['sort'] = $this->query($sql);
            $params['sort'] = ((int) $params['sort']) + 1;
        }
        
        
        if(!empty($_FILES)){
            heretic::hvar_dump($_FILES);
        }
        
        //Создание основного материала
        $dateCreate = date('Y-m-d h:i:s');
        $sql = "INSERT INTO `page` (`title`, `link`, `text`, `page_type`, `sort`, `parent_id`, `template`, `date_create`)
                VALUES ('{$params['title']}', '{$params['link']}', '{$params['text']}', '{$params['page_type']}',
                '{$params['sort']}', '{$params['parent_id']}', '{$params['template']}', '{$dateCreate}')";
        $result = $this->query($sql);        
        
        $idPage = $this->last_insert_id();
        
        if(!$result){
            return $this->bdError;
        }
        
        $modelInput = new inputModel();
        
        //Создание доп полей
        $lastId = $this->last_insert_id();
        if(is_array($auxField)){
            
            foreach ($auxField as $key => $value) {
            
                if($value['type'] == 'single_image'){
                    
                    $modelInput->updateSingleImage($value, $idPage);
                    
                }else{
                    
                    $condit = $this->confirmImage($value['field_name']); 

                    if($condit){
                    
                        if(is_array($params['h_h_h_field_inner_' . $value['field_name']])){
                            foreach($params['h_h_h_field_inner_' . $value['field_name']] as $key2 => $value2){

                                $sqlField = "INSERT INTO field_inner_{$value['field_name']} (`page_id_{$value['field_name']}`, `field_content_{$value['field_name']}`)
                                            VALUES ('{$lastId}', '{$value2}') "; 

                                $result = $this->query($sqlField);
                                if(!$result){
                                    return $this->bdError;
                                }

                            }
                        }

                    }else{
                        $sql = "INSERT INTO field_inner_{$value['field_name']} (`page_id_{$value['field_name']}`, `field_content_{$value['field_name']}`)
                            VALUES ('{$lastId}', '{$params['field_inner_' . $value['field_name']]}') "; 
                        $this->query($sql);

                        if(!$result){
                            return $this->bdError;
                        }
                    }
                    
                }
                
                

            }
            
        }
        
        
        return true;
        
    }
    
    
    /*
     * 14-10-2014
     * Редактирование материала
     * roy
     */
    
    public function editPage($params, $idPage, $auxField) {
        
        //Валидация данных
        $params['id_page'] = $idPage;
        $auxValidate = $this->auxValidate($auxField);
        $params = $this->validate($params, $rules = array(
                    'required' => 'title, page_type',
                    'string' => 'title, link, sort, page_type' . $auxValidate['string'],
                    'number' => ' ' . $auxValidate['number'],
                    'text' => 'text' . $auxValidate['text']
                ));
        
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }

        //если линк пустая, то использовать транслит
        if(empty($params['link'])) $params['link'] = $this->toTranslite($params['title']);
        
        //если sort пустое, добавляем элемент в конец
        if(empty($params['sort'])){
            $sql = "SELECT MAX(`sort`) FROM `page` WHERE `page_type` = {$params['page_type']} LIMIT 1";
            $params['sort'] = $this->query($sql);
            $params['sort'] = ((int) $params['sort']) + 1;
        }
        
        
        //Редактирование основного материала
        $dateEdit = date('Y-m-d h:i:s');
        $sql = "UPDATE `page` SET `title` = '{$params['title']}', `link` = '{$params['link']}', `text` = '{$params['text']}',
                `page_type` = '{$params['page_type']}', `sort` = '{$params['sort']}', `parent_id` = '{$params['parent_id']}', 
                `template` = '{$params['template']}', `date_edit` = '{$dateEdit}'    
                WHERE `id_page` = '{$params['id_page']}'";
                
        $result = $this->query($sql);
        
        if(!$result){
            return $this->bdError;
        }
        
        
        $modelInput = new inputModel();
        
        //Редактирование доп полей
        if(is_array($auxField)){
            foreach ($auxField as $key => $value) {
                
                if($value['type'] == 'single_image'){
                    
                    $modelInput->updateSingleImage($value, $params['id_page']);
                    
                }else{
                    
                    $condit = $this->confirmImage($value['field_name']); 

                    if($condit){

                        foreach($params['h_h_h_field_inner_' . $value['field_name']] as $key2 => $value2){

                            $sqlField = "INSERT INTO field_inner_{$value['field_name']} (`page_id_{$value['field_name']}`, `field_content_{$value['field_name']}`)
                                        VALUES ('{$params['id_page']}', '{$value2}') "; 

                            $result = $this->query($sqlField);
                            if(!$result){
                                return $this->bdError;
                            }

                        }

                    }else{



                        $sql = "SELECT `field_content_{$value['field_name']}` FROM `field_inner_{$value['field_name']}` WHERE `page_id_{$value['field_name']}` = '{$params['id_page']}'";
                        $condition = $this->query($sql);

                        if($condition){
                            $sqlField = "UPDATE `field_inner_{$value['field_name']}` SET `field_content_{$value['field_name']}` = '{$params['field_inner_'.$value['field_name']]}'
                                        WHERE `page_id_{$value['field_name']}` = '{$params['id_page']}'";
                        }else{
                            $sqlField = "INSERT INTO field_inner_{$value['field_name']} (`page_id_{$value['field_name']}`, `field_content_{$value['field_name']}`)
                                        VALUES ('{$params['id_page']}', '{$params['field_inner_' . $value['field_name']]}') "; 
                        }

                        $result = $this->query($sqlField);
                        if(!$result){
                            return $this->bdError;
                        }

                    }
                    
                    
                }

            }
        }
        
        return true;
        
    }
    
    
    
    /*
     * 14-10-2014
     * Удаление материала с полями
     * roy
     */
    
    public function deletePage($idPage){
        $params['id_page'] = $idPage;
        
        $params = $this->validate($params, $rules = array(
                'required' => 'id_page',
                'string' => 'id_page'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "SELECT * FROM `field` f 
                INNER JOIN `field_aux` a ON a.field_id = f.id_field
                INNER JOIN `page_type` pt ON pt.id_page_type = a.page_type_id 
                INNER JOIN `page` p ON p.page_type = pt.id_page_type 
                WHERE p.id_page = '{$params['id_page']}'";
        $fieldAll = $this->query($sql);
        
        $sql = "DELETE FROM `page` WHERE `id_page` = '{$params['id_page']}'";
        $result = $this->query($sql);
        
        if(!$result){
            return $this->bdError;
        }
        
        foreach ($fieldAll as $key => $value) {
            $sql = "DELETE FROM `field_inner_{$value['field_name']}` WHERE `page_id_{$value['field_name']}` = '{$params['id_page']}'";
            $this->query($sql);
            
            if(!$result){
                return $this->bdError;
            }
            
        }
        
        return true;
        
    }
    
    
    
    /*
     * 15-10-2014
     * Типы обрезки
     * roy
     */
    
    public function optionCropType(){
        $sql = "SELECT * FROM `crop_type` WHERE 1";
        $allCrop = $this->query($sql);
        
        foreach($allCrop as $key => $value){
            $result[$value['id_crop_type']] = $value['crop_type_name'];
        }
        
        return $result;
        
    }
    
    
    /*  
     * Модуль фильтров изображений
     * 
     * 
     * 15-10-2014
     * Фильтры изображений
     * roy
     */
    
    
    /*
     * 16-10-2014
     * Получить фильтр изображений по id
     * roy
     */
    
    public function getImageFilterById($idImageFilter){
        $params['id_image_filter'] = $idImageFilter;
        $params = $this->validate($params, $rules = array(
                'required' => 'id_image_filter',
                'string' => 'id_image_filter'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "SELECT * FROM `image_filter` img
                INNER JOIN `thumb_image_filter` tif ON tif.image_filter = img.id_image_filter
                INNER JOIN `medium_image_filter` mif ON mif.image_filter = img.id_image_filter
                INNER JOIN `full_image_filter` fif ON fif.image_filter = img.id_image_filter
                WHERE img.id_image_filter = '{$params['id_image_filter']}' ";
                
        $result = $this->query($sql);
        
        if(!$result){
            return $this->bdError;
        }
        
        return $result[0];
        
    }
    
    
    
    /*
     * 15-10-2014
     * Создание фильтра изображений
     * roy
     */
    
    public function addImageFilter($params){
        
        $params = $this->validate($params, $rules = array(
                'required' => 'image_filter_name',
                'string' => 'sort, thumb_width, thumb_height, thumb_dir, thumb_crop_type, medium_width, medium_height, medium_dir, medium_crop_type, full_width, full_height, full_dir, full_crop_type'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sqlFilter = "INSERT INTO `image_filter` (`image_filter_name`, `sort`) VALUES ('{$params['image_filter_name']}', '{$params['sort']}')";
        
        $resultFilter = $this->query($sqlFilter);
        
        if(!$resultFilter){
            return $this->bdError;
        }
        
        $lastId = $this->last_insert_id();
        
        $sqlThumb = "INSERT INTO `thumb_image_filter` (`thumb_width`, `thumb_height`, `thumb_dir`, `thumb_crop_type`, `image_filter`)
                    VALUES ('{$params['thumb_width']}', '{$params['thumb_height']}', '{$params['thumb_dir']}', '{$params['thumb_crop_type']}', '{$lastId}')";
        
        $sqlMedium = "INSERT INTO `medium_image_filter` (`medium_width`, `medium_height`, `medium_dir`, `medium_crop_type`, `image_filter`)
                     VALUES ('{$params['medium_width']}', '{$params['medium_height']}', '{$params['medium_dir']}', '{$params['medium_crop_type']}', '{$lastId}')";
                     
        $sqlFull = "INSERT INTO `full_image_filter` (`full_width`, `full_height`, `full_dir`, `full_crop_type`, `image_filter`)
                     VALUES ('{$params['full_width']}', '{$params['full_height']}', '{$params['full_dir']}', '{$params['full_crop_type']}', '{$lastId}')";
               
        $resultThumb = $this->query($sqlThumb);
        
        if(!$resultThumb){
            return $this->bdError;
        }  
        
        $resultMedium = $this->query($sqlMedium);
        
        if(!$resultMedium){
            return $this->bdError;
        }   
        
        $resultFull = $this->query($sqlFull);
        
        if(!$resultFull){
            return $this->bdError;
        }   
                  
        return true;
        
    }
         
    
    /*
     * 16-10-2014
     * Редактирование фильтра изображений
     * roy
     */
    
    
    public function editImageFilter($params, $idImageFilter){
        $params['id_image_filter'] = $idImageFilter;
        
        $params = $this->validate($params, $rules = array(
                'required' => 'image_filter_name, id_image_filter',
                'string' => 'sort, thumb_width, thumb_height, thumb_dir, thumb_crop_type, medium_width, medium_height, medium_dir, medium_crop_type, full_width, full_height, full_dir, full_crop_type, id_image_filter'
                ));
        
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        
        $sqlFilter = "UPDATE `image_filter` SET `image_filter_name` = '{$params['image_filter_name']}',
                      `sort` = '{$params['sort']}' WHERE `id_image_filter` = '{$params['id_image_filter']}'";
        
        $resultFilter = $this->query($sqlFilter);
        
        if(!$resultFilter){
            return $this->bdError;
        }
        
        
        $sqlThumb = "UPDATE `thumb_image_filter` SET `thumb_width` = '{$params['thumb_width']}', `thumb_height` = '{$params['thumb_height']}',
                    `thumb_dir` = '{$params['thumb_dir']}', `thumb_crop_type` = '{$params['thumb_crop_type']}'
                    WHERE `image_filter` = '{$params['id_image_filter']}'";
        
        $sqlMedium = "UPDATE `medium_image_filter` SET `medium_width` = '{$params['medium_width']}', `medium_height` = '{$params['medium_height']}',
                    `medium_dir` = '{$params['medium_dir']}', `medium_crop_type` = '{$params['medium_crop_type']}'
                    WHERE `image_filter` = '{$params['id_image_filter']}'";
                    
        $sqlFull = "UPDATE `full_image_filter` SET `full_width` = '{$params['full_width']}', `full_height` = '{$params['full_height']}',
                    `full_dir` = '{$params['full_dir']}', `full_crop_type` = '{$params['full_crop_type']}'
                    WHERE `image_filter` = '{$params['id_image_filter']}'";
                    
        $resultThumb = $this->query($sqlThumb);
        
        if(!$resultThumb){
            return $this->bdError;
        }  
        
        $resultMedium = $this->query($sqlMedium);
        
        if(!$resultMedium){
            return $this->bdError;
        }   
        
        $resultFull = $this->query($sqlFull);
        
        if(!$resultFull){
            return $this->bdError;
        }   
                  
        return true;
        
        
    }
    
    
    /*
     * 16-10-2014
     * Удаление фильтра изображений
     * roy
     */
    
    public function deleteImageFilter($idImageFilter){
        $params['id_image_filter'] = $idImageFilter;
        
        $params = $this->validate($params, $rules = array(
                'required' => 'id_image_filter',
                'string' => 'id_image_filter'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "DELETE img, tif, mif, fif
                FROM `image_filter` img, `thumb_image_filter` tif, `medium_image_filter` mif, `full_image_filter` fif
                WHERE 
                    tif.image_filter = img.id_image_filter
                    AND mif.image_filter = img.id_image_filter
                    AND fif.image_filter = img.id_image_filter
                    AND img.id_image_filter = '{$params['id_image_filter']}'";
        
        $result = $this->query($sql);        
        
        if(!$result){
            return $this->bdError;
        }   
                  
        return true;
        
    }
    
    
    /*
     * 17-10-2014
     * Получить массив с полями фильтров
     * roy
     */
    
    
    public function getFilterArray(){
        
        $criteria = "1 ORDER BY `sort` ASC";
        $imageFilter = $this->getAll('image_filter', $criteria);
        $result = '';        
        
        if(!empty($imageFilter)){
            foreach($imageFilter as $key => $value){
                $result[$value['id_image_filter']] = $value['image_filter_name']; 
            }
        }
        
        return $result;
    }
    
    
    
    /*
     * 21-10-2014
     * Получить дефолтного родителя
     * roy
     */
    
    public function getDefaultParent($idPageType){
        $params['id_page_type'] = $idPageType;
        $params = $this->validate($params, $rules = array(
            'required' => 'id_page_type',
            'string' => 'id_page_type'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "SELECT `type_parent_id` FROM `page_type` WHERE `id_page_type` = '{$params['id_page_type']}' LIMIT 1";
        $result = $this->query($sql);
        
        return $result;
        
    }
    
    /*
     * 17-12-2014
     * Получить дефолтные настройки материала
     * roy
     */
    
    public function getDefaultOptions($idPageType){
        $params['id_page_type'] = $idPageType;
        $params = $this->validate($params, $rules = array(
            'required' => 'id_page_type',
            'string' => 'id_page_type'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "SELECT `type_parent_id`, `default_template` FROM `page_type` WHERE `id_page_type` = '{$params['id_page_type']}'";
        $result = $this->query($sql);
        
        return $result[0];
    }
    
    
    
    /*
     * 22-10-2014
     * Добавить слайд
     * Roy
     */
    
    public function addSlide($params){
        
        $params = $this->validate($params, $rules = array(
            'required' => 'title',
            'string' => 'title, un_text, link, sort',
            'text' => 'text'
        ));
        
        if(!empty($_FILES['image']['name'])){
            $imageClass = new image();
            $image = $imageClass->addOneImage();
            if(!empty($image['errors'])){
                $params['valid_errors']['image'] = 'Ошибка загрузки изображения';
            }else{
                $params['image'] = $image['file_name'];
            }
        }
        
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $date = date('Y-m-d h:i:s');
        $sql = "INSERT INTO `slider` (`title`, `un_text`, `link`, `text`, `image`, `sort`, `date_create`) 
                VALUES ('{$params['title']}', '{$params['un_text']}', '{$params['link']}', '{$params['text']}', '{$params['image']}', '{$params['sort']}', '{$date}')";
        $result = $this->query($sql);        
        
        if(!$result){
            return $this->bdError;
        }
        
        return $result;
        
    }
    
    /*
     * 22-10-2014
     * Редактировать слайд
     * roy
     */
    
    public function editSlider($params, $idSlider){
        $params['id_slider'] = $idSlider;
        
        $params = $this->validate($params, $rules = array(
            'required' => 'title, id_slider',
            'string' => 'title, un_text, link, sort, id_slider',
            'text' => 'text'
        ));
        
        $imageSQL = '';
        
        if(!empty($_FILES['image']['name'])){
            $imageClass = new image();
            $image = $imageClass->addOneImage();
            if(!empty($image['errors'])){
                $params['valid_errors']['image'] = 'Ошибка загрузки изображения';
            }else{
                $params['image'] = $image['file_name'];
                $imageSQL = ", `image` = '{$image['file_name']}'";
            }
        }
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "UPDATE `slider` SET `title` = '{$params['title']}', `link` = '{$params['link']}', `text` = '{$params['text']}',
                `sort` = '{$params['sort']}', `un_text` = '{$params['un_text']}' ".$imageSQL." WHERE `id_slider` = '{$params['id_slider']}' ";        
                
        $result = $this->query($sql);        
        
        if(!$result){
            return $this->bdError;
        }
        
        return $result;
        
    }
    
    
    /*
     * 22-10-2014
     * Удаление типа материала 
     * Roy
     */
    
    public function deletePageType($idPageType){
        $params['id_page_type'] = $idPageType;
        $params = $this->validate($params, $rules = array(
            'required' => 'id_page_type',
            'string' => 'id_page_type'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "DELETE FROM `page_type` WHERE `id_page_type` = '{$params['id_page_type']}'";        
        $result = $this->query($sql);        
        
        if(!$result){
            return $this->bdError;
        }
        
        $sql = "DELETE FROM `page` WHERE `page_type` = '{$params['id_page_type']}'";
        $result = $this->query($sql);        
        
        if(!$result){
            return $this->bdError;
        }
        
        return $result;
        
    }
    
    
    /*
     * 5-12-2014
     * Сохранение адреса
     * roy
     */
    
    public function saveMail($params){
        
        $params = $this->validate($params, $rules = array(
                    'required' => 'id_mail, mail',
                    'string' => 'id_mail, mail'
                ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "UPDATE `mail` SET `mail` = '{$params['mail']}' WHERE `id_mail` = '{$params['id_mail']}'";
        $result = $this->query($sql);
        
        if($result){
            return array('success' => 'Адрес успешно изменён');
        }else{
            return array('errors' => 'Ошибка БД');
        }
        
        
        
    }
            
    
    /*
     * 17-12-2014
     * Типы страниц
     * roy
     */
    
    public function getPageTypeSelect(){
        
        $result = '';
        
        $sql = "SELECT * FROM `page_type` WHERE 1 ORDER BY `sort` ASC";
        $presive = $this->query($sql);
        
        if(is_array($presive)){
            foreach ($presive as $key => $value) {
                $result[$value['id_page_type']] = $value['title']; 
            }
        }
        
        array_unshift($result, 'Перечисление'); 
        
        return $result;
        
    }
    
    /*
     * 19-01-2015
     * Выдача результата flash
     * roy
     */
    
    public static function getResultFlash(){
        
        if(!empty($_SESSION['success'])){
            echo "<div class='alert alert-success'><strong>Успех!</strong> " . $_SESSION['success'] . "</div>";
            heretic::destroyFlash('success');
        }
        
        if(!empty($_SESSION['errors'])){
            echo "<div class='alert alert-danger'><strong>Ошибка!</strong>  " . $_SESSION['errors'] . "</div>";
            heretic::destroyFlash('errors');
        }
        
    }
    
    /*
     * 20-01-2015
     * Отмечаем магазин на карте
     * roy
     */
    
    public function setShopOnMap($params){
        
        $params = $this->validate($params, $rules = array(
            'required' => 'page_id, shop_path',
            'string' => 'page_id, shop_path'
        ));
        
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql2 = "UPDATE `shop_map` SET `page_id` = 0 WHERE `page_id` = {$params['page_id']}";
        $this->query($sql2);
        
        $sql = "UPDATE `shop_map` SET `page_id` = {$params['page_id']} WHERE `shop_path` = '{$params['shop_path']}'";
        $result = $this->query($sql);
        
        if($result){
            return array('success' => 'Отметить на карте удалось');
        }else{
            return array('errors' => array('mysql_error' => 'Произошла ошибка БД'));
        }
        
    }
            
    
    /*
     * 22-01-2015
     * Вывод всех возможных объектов
     * roy
     */
    
    public function getArendSelect(){
        
        $result = array();
        
        
        $sql = "SELECT * FROM `page` p
                WHERE (p.page_type = 3 OR p.page_type = 6 OR p.page_type = 7) 
                AND p.id_page NOT IN
                    (SELECT `id_page` FROM `arend_brand` WHERE 1) ORDER BY p.title ASC";
        
        $allShop = $this->query($sql);
        
        return $allShop;
        
    }
    
    
    /*
     * 22-01-2015
     * Добавить якорного арендатора
     * roy
     */
    
    public function addArendBrand($params){
        
        $params = $this->validate($params, $rules = array(
            'required' => 'id_page',
            'string' => 'id_page'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql2 = "SELECT * FROM `arend_brand` WHERE 1";
        $count = count($this->query($sql2));
        
        $sql = "INSERT INTO `arend_brand` (`id_page`, `sort`) VALUES ('{$params['id_page']}', '{$count}')";
        $result = $this->query($sql);
        
        if($result){
            return array('success' => 'Якорный арендатор успешно добавлен');
        }else{
            return array('errors' => 'Ошибка БД');
        }
        
    }
    
    
    /*
     * 22-01-2015
     * Удаление якорного арендатора
     * roy
     */
    
    public function deleteArendBrand($idArendBrand){
        
        $params['id_page'] = $idArendBrand;
                
        $params = $this->validate($params, $rules = array(
            'required' => 'id_page',
            'string' => 'id_page'
        ));
        
        $sql = "DELETE FROM `arend_brand` WHERE `id_page` = {$params['id_page']}";
        
        $result = $this->query($sql);
        
        if($result){
            return array('success' => 'Якорный арендатор успешно удалён');
        }else{
            return array('errors' => 'Ошибка БД');
        }
        
    }
    
}
