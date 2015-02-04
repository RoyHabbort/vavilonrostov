<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newsController
 *
 * @author Рой
 */
class newsController extends controllerClass {
    
    
    
    public function index($params){
        
        $pagination = (!empty($params[0])) ? (integer) $params[0] : 1;
        
        $model = new Page();
        
        $criteria = "`page_type` = 10 ORDER BY `date_create` DESC";
        $presive = $model->getAll('page', $criteria);
        
        $result = array();
        if(!empty($presive)){
            foreach($presive as $key => $value){
                $result[] = $model->getPageById($value['id_page']);
            }
        }
        
        heretic::setTitle('Новости и события');
        
        $this->render('_newsAll', array(
            'result' => $result,
            'pagination' => $pagination,
            'link' => 'news'
        ));
        
    }
    
    
}
