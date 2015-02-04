<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminWidget
 *
 * @author Рой
 */
class adminWidget extends widgetClass{
    
    public function arendBrand($params){
        
        $model = new page();
        $modelAdmin = new Admin();
        
        $allArend = $modelAdmin->getArendSelect();
        
        $presive = $model->getAll('arend_brand', '1 ORDER BY `sort` ASC');
        
        $result = array();
        if(!empty($presive)) {
            foreach ($presive as $key => $value) {
                $result[] = $model->getPageById($value['id_page']);
            }
        }
        
        $this->render('_adminBrand', array(
            'result' => $result,
            'allArend' => $allArend,
            'page_id' => $params['page_id'],
            'page_type' => $params['page_type']
        ));
        
    }
    
}
