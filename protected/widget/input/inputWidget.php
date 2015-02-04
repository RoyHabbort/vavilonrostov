<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inputWidget
 *
 * @author Рой
 */
class inputWidget extends widgetClass{
    
    
    public function index($params){
        
        $model = new page();
        
        $function = $params['type'] . 'Function';
        
        $result = $this->$function($params, $model);
        
        if(!$result){
           echo "Поле {$params['type']} не было загружено, из-за ошибки в коде."; 
        }
        
    }
    
    
    
    //обычный селект
    public function selectFunction($params, $model){
        $this->render('_select', $params);
        return true;
    }
    
    
    //поле даты
    public function dateFunction($params, $model){
        $this->render('_date', $params);
        return true;
    }
    
    //текстовое поле
    public function textareaFunction($params, $model){
        $this->render('_textarea', $params);
        return true;
    }
    
    //текстовое поле без CKeditor
    public function textarea_noFunction($params, $model){
        $params['no-CK'] = 1;
        $this->render('_textarea', $params);
        return true;
    }
    
    //обычное поле ввода
    public function textFunction($params, $model){
        $this->render('_text', $params);
        return true;
    }
    
    //поле изображений
    public function imageFunction($params, $model){
        $this->render('_image', $params);
        return true;
    }
    
    //checkbox
    public function checkboxFunction($params, $model){
        $this->render('_checkbox', $params);
        return true;
    }
    
    
    //одиночное изображение
    public function single_imageFunction($params, $model){
        
        $name = str_replace('field_inner_', '', $params['name']);
        
        $model = new inputModel();
        
        $result = $model->getImageFilter($name);
        
        $params['filter'] = $result;
        
        $this->render('_single_image', $params);
        return true;
    }
    
    
    
    /*
     * 18-12-2014
     * Выбор из готовых материалов
     * Обычный селект, который в качестве 
     * предустановленых выборов предлагает нам,
     * какие-то материалы из БД
     * roy
     */
    public function selecterFunction($params, $model){
        $presiveComplite = '';
        
        $selecter = unserialize($params['selector']);
        
        if(is_array($selecter)){//если у нас уже массив данных
            
            foreach($selecter as $key => $value){
                $presiveComplite[$value] = $value;
            }
            
            $params['result'] = (!empty($params['result'])) ? $params['result'] : $selecter[0];
            
        }else{//иначе выборка из базы
            
            $criteria = "`page_type` = '{$selecter}' ORDER BY `sort` ASC";
            $presive = $model->getAll('page', $criteria);

            if(is_array($presive)){
                foreach($presive as $key => $value){
                    $presiveComplite[$value['id_page']] = $value['title']; 
                }
            }
        }    

        $params['options'] = $presiveComplite;

        $this->render('_select', $params);
            
        
        return true;
    }
    
    
    
    //выбор темплейтов
    public function templateFunction($params, $model){
        $result = '';
                
        $dir = 'protected/views/page';
        if(is_dir($dir)) {

            $files = scandir($dir);

            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'

            foreach ($files as $key => $value) {
                $presive = str_replace('.php', '', $value);
                $result[$presive] = $presive;
            }

        }

        if(empty($result)){
            $this->render('_text', $params);
            return true;
        }


        $params['options'] = $result;
        $this->render('_select', $params);

        return true;
    }
    
    
}
