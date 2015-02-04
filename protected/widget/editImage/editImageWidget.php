<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of editImageWidget
 *
 * @author Иноходец
 */
class editImageWidget extends widgetClass{
    
    
    public function index($params){
        
        $model = new admin();
        $imageFilter = $model->getImageFilterById($params['option']['image_filter']);
        foreach ($params['result'] as $key => $value) {
            $params['result'][$key]['path'] = heretic::$_path['images'] . $imageFilter['thumb_dir'] . '/' . $value['content'];
        }
        $this->render('_editImage', array('image' => $params, 'image_filter' => $imageFilter));
        
    }
    
}
