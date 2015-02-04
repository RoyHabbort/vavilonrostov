<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mail
 *
 * @author Рой
 */
class review extends modelsClass{
    
    
    public function addReview($params){
        
        $params = $this->validate($params, $rules = array(
                'required' => 'name, email, text',
                'string' => 'name, email',
                'text' => 'text'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $date = date('Y-m-d h:i:s');
        
        $sql = "INSERT INTO `reviews` (`name`, `email`, `text`, `date`, `moderation`)
                VALUES ('{$params['name']}', '{$params['email']}', '{$params['text']}', '{$date}', 0)";
                
        $result = $this->query($sql);        
        
        if($result){
            return array('success' => 'Отзыв добавлен');
        }else{
            return array('errors' => array('public_error' => 'Ошибка БД'));
        }
        
    }
    
    
    
    public function reviewSuccess($idReview){
        
        $params['id_reviews'] = $idReview;
        
        $params = $this->validate($params, $rules = array(
            'required' => 'id_reviews',
            'string' => 'id_reviews'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "UPDATE `reviews` SET `moderation` = 1 WHERE `id_reviews` = '{$params['id_reviews']}'";
        
        $result = $this->query($sql);
        
        if($result){
            return array('success' => 'Отзыв одобрен');
        }else{
            return array('errors' => array('public_error' => 'Ошибка БД'));
        }
        
    }
    
}
