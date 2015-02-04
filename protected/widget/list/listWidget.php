<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listWidget
 *
 * @author Рой
 */
class listWidget extends widgetClass {
    
    private $data = array();
    private $result = array();
    private $page = 1;
    private $count_ellement;
    private $views = '';
    private $pagination_type = 1;
    private $href = '';  //адрес для кнопок пагинации
    private $count_page = 10; //число выводимых элементов
    private $end_element = 10;
    private $start_element = 1;
    private $elements;
    private $element_href =''; //адресс ссылки для элементов
    private $pagination_cout = 10;
    private $pag_to = array();
    private $paginationTemplate = 'pagination'; //шаблон для кнопок пагинации
    
    
    public function index($params){
        
        $this->data = $params['data'];
        $this->views = $params['views'];
        $this->pagination_cout = (!empty($params['pagination_cout'])) ? $params['pagination_cout'] : $this->pagination_cout;
        $this->href = (!empty($params['href'])) ? $params['href'] : $this->href;
        $this->element_href = (!empty($params['element_href'])) ? $params['element_href'] : $this->element_href;
        $this->pagination_type = (!empty($params['pagination_type'])) ? $params['pagination_type'] : $this->pagination_type;
        $this->page = (!empty($params['page'])) ? $params['page'] : $this->page;
        $this->count_ellement = (!empty($params['count_elment'])) ? $params['count_elment'] : $this->count_ellement;
        $this->paginationTemplate =  (!empty($params['paginationTemplate'])) ? $params['paginationTemplate'] : $this->paginationTemplate;
        
        $this->pagination();
        $this->getPage();
        
        $this->pag_to = $this->paginCount();
        
        if ((($this->pagination_type == 1)||($this->pagination_type == 2))&&($this->count_page>1))
            $this->render($this->paginationTemplate, array('pag_to'=>$this->pag_to, 'page'=>$this->page, 'href'=> $this->href, 'count_page' => $this->count_page));
        
        $this->render($this->views, array('result' => $this->result, 'element_href'=> $this->element_href));
        
        if ((($this->pagination_type == 1)||($this->pagination_type == 3))&&($this->count_page>1))
            $this->render($this->paginationTemplate, array('pag_to'=>$this->pag_to, 'page'=>$this->page, 'href'=> $this->href, 'count_page' => $this->count_page));

    }
    
    private function pagination(){
        $count_all = count($this->data);
        $this->count_page = ceil($count_all/$this->count_ellement);
    }
    
    private function getPage(){
        
        $this->start_element = ($this->page-1)*$this->count_ellement;
        $this->end_element = $this->start_element + $this->count_ellement -1;
        
        $this->result = array();
        foreach ($this->data as $key => $value) {
            if (($key>=$this->start_element)&&($key<=$this->end_element)){
                $this->result[] = $value;
            }
        }
        
    }
    
    private function paginCount(){
        $paginResult = array();
        
        if($this->count_page < $this->pagination_cout){
            $paginResult['start'] = 1;
            $paginResult['end'] = $this->count_page;
        }else{
            
            $pageToFront = floor($this->pagination_cout / 2);
            $pageToBack = ceil($this->pagination_cout / 2);
                
            $paginResult['start'] = $this->page - $pageToBack;
            $paginResult['end'] = $this->page + $pageToFront;
            if ($paginResult['start'] < 1) $paginResult['start'] = 1;
            if ($paginResult['end'] > $this->pagination_cout) $paginResult['end'] = $this->pagination_cout;
            
            
        }
        return $paginResult;
    }
    
    
}
