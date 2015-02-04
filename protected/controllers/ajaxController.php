<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ajaxController
 *
 * @author Рой
 */
class ajaxController extends controllerClass{
    
    public function index(){
        errorClass::getPageError(404);
    }
    
    
    /*
     * 17-10-2014
     * Загрузка изображений на сервер
     * roy
     */
    
    public function jqueryUpload(){
        $this->confirmRules();
        $this->confirmAjax();
        $model = new image();
        
        if(!empty($_FILES)){
            $result = $model->uploadImage();
            echo json_encode($result);
        }else{
            $result = array('errors' => 'Ошибка загрузки');
            echo json_encode($result); 
        }
        
    }
    
    
    /*
     * 18-10-2014
     * Удаление изображения
     * roy
     */
    
    public function deleteImage(){
        $this->confirmRules();
        $this->confirmAjax();
        $model = new image();
        
        if(!empty($_POST)){
            $result = $model->deleteImage($_POST);
            echo json_encode($result);
        }else{
            $result = array('errors' => 'Ошибка удаления');
            echo json_encode($result);
        }
    }
    
    
    /*
     * 21-10-2014
     * Обратная связь
     * roy
     */
    
    public function addSignup(){
        
        if(!empty($_POST)){
            
            $model = new page();
            $mail = new mail();
            $post = $_POST['order'];
            $post = $model->validate($post, $rules = array(
                'required' => 'fio, email, question',
                'string' => 'fio, email',
                'text' => 'question'
            ));

            if(!empty($post['valid_errors'])){
                echo json_encode(array('errors' => 'Форма заполнена неверно', 'valid_errors' => $post['valid_errors']));
                exit;
            }
        
            $form = array(
                'to' => 'Олег',
                'toMail' => 'resq7@mail.ru',
                'fromName' => $post['fio'],
                'from' => $post['email'],
                'subject' => 'Обратная связь',
                'template' => 'signup',
                'data' => $post
            );
            
            $result = $mail->sendMail($form);

            if($result){
                echo json_encode(array('success' => 'Ваша заявка принята.'));
            }else{
                echo json_encode(array('errors' => array('public_error' => 'Произошла непредвиденая ошибка. Попробуйте обновить страницу')));
            }
        }
        
    }
    
    
    /*
     * 10-2014
     * Проверка прав пользователя
     * roy
     */
    
    private function confirmRules(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
    } 
    
    /*
     * 10-2014
     * Проверка на то, что пришёл аякс
     * roy
     */
    
    private function confirmAjax() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            return true;
            
        }else{
            errorClass::getPageError(404);
            exit();
        }
    }
    
    
    /*
     * 2-12-2014
     * Выдача всех номеров
     * roy
     */
    
    public function getAllAppartaments(){
        $model = new page();
        $criteria = " `page_type` = 5 ORDER BY `sort` ASC";
        $promise = $model->getAll('page', $criteria);
        
        if(!empty($promise)&&($promise)){
            $result = array();
            
            foreach ($promise as $key => $value) {
                $result[] = $model->getPageByLink($value['link']);
            }
            
            if(!empty($result)&&($result)){
                echo json_encode(array('success' => 'Информация о комнатах получена', 'appartaments' => $result));
            }else{
                echo json_encode(array('errors' => 'Информация о номерах отсутствует'));
            }
            
            
        }else{
            echo json_encode(array('errors' => 'Ошибка БД'));
        }
           
    }
    
    /*
     * 2-12-2014
     * Выдача номера по линку
     * roy
     */
    
    public function getAppartmentByLink(){
        
        $model = new page();
        if(!empty($_POST)){
            
            $post = $_POST['data'];
            $post = $model->validate($params, $rules = array(
                'string' => 'link'
            ));
            
            $criteria = "`page_type` = 5 AND `link` = '{$post['link']}'";
            $promise = $model->getAll('page', $criteria);
            
            if(empty($promise)){
                echo json_encode(array('errors' => 'Ошибка синхронизации'));
                exit;
            }
            
            $result = $model->getPageByLink($promide[0]['link']);
            
            if(!empty($result)&&($result)){
                echo json_encode(array('success' => 'Информация о комнате получена', 'appartament' => $result));
            }else{
                echo json_encode(array('errors' => 'Ошибка БД'));
            }
            
            
        }else{
            echo json_encode(array('errors' => 'Ошибка синхронизации'));
        }
        
        
    }
    
    
    /*
     * 3-12-2014
     * Оставить заявку на конгресс холл
     * roy
     */
    
    public function sendOrder(){
        
        $postdata = file_get_contents("php://input");
        $post = json_decode($postdata);
        
        $model = new page();
        if(!empty($post->data)){
            $post = (array) $post->data;
            $post = $model->validate($post, $rules = array(
                'required' => 'date, time, duration, phone',
                'string' => 'date, time, duration, phone',
                'text' => 'description'
            ));
            
            if(!empty($post['valid_errors'])){
                echo json_encode(array('errors' => 'Форма заполнена неверно', 'valid_errors' => $post['valid_errors']));
                exit;
            }
            
            $mail = new mail();
            $form = array(
                'to' => heretic::$_config['mail']['name'],
                'toMail' => heretic::$_config['mail']['email'],
                'fromName' => heretic::$_config['mail']['name'],
                'from' => heretic::$_config['mail']['email'],
                'subject' => 'Заказ конгресс хола',
                'template' => 'kongress',
                'data' => $post,
            );
            
            
            $result = $mail->sendMail($form);

            if($result){
                echo json_encode(array('success' => 'Ваша заявка принята.'));
            }else{
                echo json_encode(array('errors' => array('public_error' => 'Произошла непредвиденая ошибка. Попробуйте обновить страницу')));
            }
            
            
        }else{
            echo json_encode(array('errors' => 'Ошибка синхронизации'));
        }
        
    }
    
    
    /*
     * 21-01-2015
     * Письмо с заказом аренды
     * roy
     */
    
    public function orderArend(){
        
        if(!empty($_POST)){
            
            $model = new page();
            $mail = new mail();
            $post = $_POST['order'];
            $post = $model->validate($post, $rules = array(
                'required' => 'famaly, name, date, description, phone',
                'string' => 'famaly, name, date, phone',
                'text' => 'description'
            ));
            
            if(!empty($post['valid_errors'])){
                echo json_encode(array('errors' => 'Форма заполнена неверно', 'valid_errors' => $post['valid_errors']));
                exit;
            }
            
            $form = array(
                'to' => 'resq7@mail.ru',
                'toMail' => 'resq7@mail.ru',
                'fromName' => $post['famaly'],
                'from' => 'resq7@mail.ru',
                'subject' => 'Заявка от арендатора ',
                'template' => 'order',
                'data' => $post,
            );
            
            $result = $mail->sendMail($form);

            if($result){
                echo json_encode(array('success' => 'Ваша заявка принята.'));
            }else{
                echo json_encode(array('errors' => array('public_error' => 'Произошла непредвиденая ошибка. Попробуйте обновить страницу')));
            }
            
        }
        
        
        
    }
    
}
