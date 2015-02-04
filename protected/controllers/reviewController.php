<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reviewController
 *
 * @author Рой
 */
class reviewController extends controllerClass{
    
    
    public function addReview(){
        
        if(empty($_POST)){
            echo json_encode( array('errors' => array('public_error' =>  'Форма отзыва пуста')));
            exit;
        }
        
        $review = new Review();
        $result = $review->addReview($_POST);
        
        if(!empty($result['errors'])){
            echo json_encode(array('errors' => $result['errors']));
            exit;
        }else{
            if(!empty($result['success'])){
                echo json_encode(array('success' => $result['success']));
                exit;
            }
        }
        
    }
    
}
