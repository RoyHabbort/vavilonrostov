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
class mail extends PHPMailer{
    
    /*
     * 3-12-2014
     * Отправление письма
     * roy
     */
    
    public function sendMail($params){
        
        $this->From = $params['from'];
        $this->FromName = $params['fromName'];
        $this->Subject = $params['subject'];
        
        $template = $params['template'].'Template';
        $this->Body = $this->$template($params);
        $this->isHTML(true);
        
        $this->AddAddress($params['toMail'], $params['to']);
        
        if(!$this->Send()) return false;
            else return true;
        
    }
    
    /*
     * 3-12-2014
     * Форматирование письма для singup
     * roy
     */
    
    private function signupTemplate($params){
        $views = new viewsClass();
        $body = '';
        $body .= "Сообщение: {$params['data']['question']}<br />";
        $body .= "Почта : " . $params['data']['email'] . '<br />';
        $body .= $params['data']['fio'];
        
        return $body;
        
    }
    
    /*
     * 3-12-2014
     * Форматирование письма для бронирования конгрессхола
     * roy
     */
    
    private function kongressTemplate($params){
        $body = '';
        $body .= 'Забронировать конгрессхолл';
        return $body;
    }
    
    
    
    private function formatedBody($params){
        
        $body = '';
        $body .= '' . $params['fio'] . '<br/>';
        $body .= 'Комментарий : ' . $params['comment'] . '<br/>';
        $body .= 'Номер телефона :' . $params['phone'];
        return $body;
        
    }
    
    
    
    private function orderTemplate($params){
        $body = 'Заявка от арендатора <br/>';
        $body .= 'Сообщение : ' . $params['data']['description'] . '<br/>';
        
        $body .= 'Предполагаемая дата :' . $params['data']['date'] . '<br/>';
        $body .= 'Номер телефона :' . $params['data']['phone'] . '<br/>';
        $body .= $params['data']['famaly'] . ' ' . $params['data']['name'] . '<br/>';
        return $body;
    }
    
    
    private function subscribTemplate($params){
        $body = '<h2 style="font-size:18px; margin-bottom:10px;">Подписка на рассылку </h2>';
        $body .= '<p>Фамилия: ' . $params['data']['s_famaly'] . '</p>';
        $body .= '<p>Имя: ' . $params['data']['s_name'] . '</p>';
        if(!empty($params['data']['s_sename'])){ $body .= '<p>Отчество: ' . $params['data']['s_sename'] . '</p>'; }
        if(!empty($params['data']['s_date_bthd'])){ $body .= '<p>День рождения: ' . $params['data']['s_date_bthd'] . '</p>'; }
        
        $body .= '<p>Пол: '; 
        $body .= ($params['data']['sex'] == 'male') ? 'мужской': 'женский';
        $body .= '</p>';
        
        
        if(!empty($params['data']['s_email'])){ $body .= '<p>Email: ' . $params['data']['s_email'] . '</p>'; }
        if(!empty($params['data']['s_phone'])){ $body .= '<p>Телефон: ' . $params['data']['s_phone'] . '</p>'; }
        
        
        $body .= '<p>Дети до 12 лет: '; 
        $body .= ($params['data']['s_child'] == 'yes') ? 'да': 'нет';
        $body .= '</p>';
        
        if(!empty($params['data']['s_city'])){ $body .= '<p>Город: ' . $params['data']['s_city'] . '</p>'; }
        if(!empty($params['data']['s_adress'])){ $body .= '<p>Адрес: ' . $params['data']['s_adress'] . '</p>'; }
        
        if(!empty($params['data']['integesting'])){
            $body .= '<p>Интересующие категории: ';
            foreach ($params['data']['integesting'] as $key => $value) {
                $body .= $value . ', ';
            }
            $body .= '</p>';
        }
        
        
        return $body;
    }
    
    
    
}
