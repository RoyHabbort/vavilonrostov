<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainController
 *
 * @author Рой
 */
class pageController extends controllerClass{
    
    /*
     * 10-2014
     * Установка активной страницы
     * roy
     */
    
    private function setActivePage($link){
        heretic::$active_page = $link;
    }
    
    
    /*
     * 10-2014
     * Получить шаблон данного материала
     * roy
     */
    
    private function getTemplate($page){
        
        if(!empty($page['template'])){
            
            if(!file_exists(heretic::$_path['views'].'page/'.$page['template'].'.php')){
                return false;
            }
            return $page['template'];
        }else{
            return 'page';
        }
        
    }
    
    /*
     * 10-2014
     * Вывод главной страницы
     * roy
     */
    
    public function index() { 
        
        heretic::setTitle('торгово-развлекательный центр');
        $models = new page();
        $this->setActivePage('/');
        $result = $models->getMainPage();
        $template = $this->getTemplate($result);
        
        if (!isset($_SERVER["HTTP_X_PJAX"])){
            $this->render('index', array('result' => $result, 'main' => 1));
        }else{
            $this->partialRender('index', array('result' => $result, 'main' => 1));
        }
        
    }
    
    
    /*
     * 23-01-2015
     * оформление подписки
     * roy
     */

    public function subsсrib(){
        
        $model = new page();
        
        $category = $model->getAll('page', "`page_type` = 2 ORDER BY `sort` ASC");
        
        $category[] = array('title' => 'Рестораны и кафе');
        $category[] = array('title' => 'Развлечения');
        
        
        if(!empty($_POST)){
            
            $post = array(
                's_famaly' => (!empty($_POST['s_famaly'])) ? $_POST['s_famaly'] : '',
                's_name' => (!empty($_POST['s_name'])) ? $_POST['s_famaly'] : '',
                's_sename' => (!empty($_POST['s_sename'])) ? $_POST['s_sename'] : '',
                's_date_bthd' => (!empty($_POST['s_date_bthd'])) ? $_POST['s_date_bthd'] : '',
                'sex' => (!empty($_POST['sex'])) ? $_POST['sex'] : '',
                's_email' => (!empty($_POST['s_email'])) ? $_POST['s_email'] : '',
                's_phone' => (!empty($_POST['s_phone'])) ? $_POST['s_phone'] : '',
                's_child' => (!empty($_POST['s_child'])) ? $_POST['s_child'] : '',
                's_city' => (!empty($_POST['s_city'])) ? $_POST['s_city'] : '',
                's_adress' => (!empty($_POST['s_adress'])) ? $_POST['s_adress'] : '',
                'pers_data' => (!empty($_POST['pers_data'])) ? $_POST['pers_data'] : '',
                'integesting' => (!empty($_POST['integesting'])) ? $_POST['integesting'] : array()
            );
            
            
            $post = $model->validate($post, $rules = array(
                'required' => 's_famaly, s_name, s_date_bthd, sex, s_email, s_child, pers_data',
                'string' => 's_famaly, s_name, s_sename, s_date_bthd, sex, s_email, s_phone, s_child, s_city, s_adress, pers_data'
            ));
            
            if(!empty($post['integesting'])){
                foreach ($post['integesting'] as $key => $value) {
                    $post['integesting'][$key] = $key;
                }
            }
            
            if(!empty($post['valid_errors'])){
                
                $this->render('subscrib', array(
                    'category' => $category,
                    'post' => $post,
                    'errors' => $post['valid_errors']
                ));
                return true;
            }else{
                
                $mail = new mail();
                
                $form = array(
                    'to' => 'Олег',
                    'toMail' => 'resq7@mail.ru',
                    'fromName' => $post['s_famaly'],
                    'from' => $post['s_email'],
                    'subject' => 'Подписка на рассылку',
                    'template' => 'subscrib',
                    'data' => $post
                );

                $result = $mail->sendMail($form);

                if($result){
                    
                    heretic::redirect('success', '/page/subsсrib', 'Подписка на рассылку успешно оформлена.');
                    
                }else{
                    
                    $this->render('subscrib', array(
                        'category' => $category,
                        'post' => $post,
                        'errors' => array('bad_error' => 'Произошла непредвиденная ошибка. Попробуйте повторить позже.')
                    ));
                    
                }
                
            }
            
            
        }else{
            
            $this->render('subscrib', array(
                'category' => $category
            ));
            
        }
        
        
        
    }
    
    
    /*
     * 10-2014
     * Вывод внутренних страниц
     * roy
     */
    
    public function pageList($params){
        if(empty($params)){
            errorClass::getPageError(404);
            return false;
        }
        
        $model = new page();
        $page = $model->extractLink($params);
        
        $stockOpt = (!empty($params[1])) ? $params[1] : '' ;
        
        $this->setActivePage($page);
        $result = $model->getPageByLink($page);
        
        if(empty($result) || !empty($result['errors'])){
            errorClass::getPageError(404);
            return false;
        }
        heretic::setTitle($result['title']);
        $template = $this->getTemplate($result);
        
        if (!isset($_SERVER["HTTP_X_PJAX"])){
            $this->render($template, array('result' => $result, 'stockOpt' => $stockOpt));
        }else{
            $this->partialRender($template, array('result' => $result, 'stockOpt' => $stockOpt));
        }
        
    }
 
    
    
    
    
    
    
}