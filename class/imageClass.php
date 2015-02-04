<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imageClass
 *
 * @author Рой
 */
class imageClass {

    /*
     * 10-2014
     * Подтверждение существования директории
     * А точнее, если директория ещё не существует,
     * то создать её с правами администратора
     * roy
     */
    
    private function confirmDir($dir){
        if(!file_exists($dir)){
            mkdir($dir, 0777);
            chmod($dir, 0777);
        }
    }
    
    
    /*
     * 12-12-2014
     * Стандартная функция загрузки изображения
     * roy
     */
    
    public function uploadStandart($params){
                        
        //проверяем полученно имя файла
        if(empty($params['file'])){
            return false;
        }         
        
        //проверяем дополнительнаые параметры
        $params['width'] = (!empty($params['width'])) ? $params['width'] : 0;
        $params['height'] = (!empty($params['height'])) ? $params['height'] : 0;
        $params['mimeType'] = (!empty($params['mimeType'])) ? $params['mimeType'] : 'image/jpg';
        $params['dir'] = (!empty($params['dir'])) ? $params['dir'] : 'all';  
        $params['fileName'] = (!empty($params['fileName'])) ? $params['fileName'] : uniqid() . '_' . $_FILES[$params['file']]; 
        
        //если тип изображения jpeg, вести себя так же как jpg
        if($params['mimeType'] == 'image/jpeg'){
            $params['mimeType'] = 'image/jpg';
        }
        
        //извлекаем фаил из массива фаилов
        $image = $_FILES[$params['file']];
        
        //обрабатываем изображение указанной функцией
        $imageNew = $this->$params['crop']($image['tmp_name'], $params['mimeType'], $params['width'], $params['height']);
        
        //получаем полный путь для дириктории
        if(!empty($params['fullDir'])){
            $uploaddir = $params['fullDir'];
        }else{
            $uploaddir = heretic::$_path['images'] . $params['dir'] . '/';
        }
        
        
        //проверяем наличие дириктории
        $this->confirmDir($uploaddir);
        
        //создаём полное имя загружаемого файла
        $uploadfile =  $uploaddir . $params['fileName'];

        //загружаем фаил в замисимости от типа
        switch ($params['mimeType']) {
            
            case 'image/jpg':
                $result = imagejpeg($imageNew, $uploadfile, 90);
                break;
            
            case 'image/gif':                
                $result = imagegif($imageNew, $uploadfile, 2);
                break;
            
            case 'image/png':
                $result = imagepng($imageNew, $uploadfile, 2);
                break;

            default:
                $result = imagejpeg($imageNew, $uploadfile, 90);
                break;
            
        }
        
        //возвращаем результаты работы
        if ($result){
            return true;
        }else{
            return false;
        }
        
    }
    
    
    
    /**************************************
     * 10-2014
     * Функции обработки изображения
     * Данный раздел полностью посвящён логике
     * обработки изображения при загрузке на сервер
     * roy
     **************************************/
            
    
    /*
     * 10-2014
     * 
     * function compress
     * 
     * Функции ужимания.
     * Принимают исходное изображение $image
     * и параметры требуемых ширины и высоты 
     * 
     * После чего, создают новое изображение
     * и изменяют размеры исходного изображения
     * под новые параметры.
     * 
     * Если соотношение сторон нового и старого 
     * изображения не соответствуют, то 
     * ужимается по стороне до нужного размера
     * 
     * roy
     */
    
    private function compress($image, $mimeType, $newWidth = 0, $newHeight = 0){
        list($oldWidth, $oldHeight) = getimagesize($image);
        
        if($oldWidth < $newWidth){
            $newWidth = $oldWidth;
            $newHeight = $oldHeight;
        }
        
        if (!$newHeight){
            $ratio = $newWidth/$oldWidth;
            $newHeight = round($oldHeight * $ratio); 
        }
        
        
        $imageNew = imagecreatetruecolor($newWidth, $newHeight);
        
        switch ($mimeType) {
            
            case 'image/jpg':
                $imageOld = imagecreatefromjpeg($image);
                $result = imagecopyresampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
                break;
            
            case 'image/gif':
                $imageOld = imagecreatefromgif($image);
                $result = imagecopyresampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
                break;
            
            case 'image/png':
                //Отключаем режим сопряжения цветов
                imagealphablending($imageNew, false);
                 //сохраняем альфаканал
                imagesavealpha($imageNew, true);
                
                $imageOld = imagecreatefrompng($image);
                $result = imagecopyresampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
                break;

            default:
                return $image;
                break;
        }
        
        return $imageNew;
        
    }
    
    
    
    /*
     * 15-12-2014
     * Функция обрезки и центровки
     * Если картинка больше по какой-либо стороне
     * заданного ей размера, то она обрезается
     * и отцентровывается
     * roy
     */
    
    private function cropCenter($image, $mimeType, $newWidth = 0, $newHeight = 0){
        list($oldWidth, $oldHeight) = getimagesize($image);
        //echo "NEW TYPE <br /><br />";
        
        //echo "oldWidth = " . $oldWidth . "<br />";
        //echo "oldHeight = " . $oldHeight . "<br />";
        
        //echo "newWidth = " . $newWidth . "<br />";
        //echo "newHeight = " . $newHeight . "<br />";
        
        //если новая ширина, меньше старой, то обрезать не нужно 
        if(!$newWidth && !$newHeight){
            return $image;
        }
        
        //если не задана высота, то расчитать
        if(!$newHeight){
            $ratio = $newWidth/$oldWidth;
            $newHeight = round($oldHeight * $ratio); 
        }
        
        //если не задана ширина, то расчитать
        if(!$newWidth){
            $ratio = $newHeight/$oldHeight;
            $newWidth = round($oldWidth * $ratio);
        }
        
        //получение ratio
        $ratioX = $newWidth/$oldWidth;
        $ratioY = $newHeight/$oldHeight;
        
        //echo "ratioX = " . $ratioX . '<br />';
        //echo "ratioY = " . $ratioY . '<br />';
        
        //берём модули ратио для сравнения
        $ratioAbsX = abs(1 - $ratioX);
        $ratioAbsY = abs(1 - $ratioY);
        
        //искомое ратио равно наиближайшему к 1 
        $ratioRequired = ($ratioAbsX < $ratioAbsY) ? $ratioX : $ratioY;
        
        //echo '$ratioRequiredX = ' . $ratioRequiredX . '<br />';
        //echo '$ratioRequiredY = ' . $ratioRequiredY . '<br />';
        
        //для чего нам было нужно ратио
        //правильно, чтобы расчитать высоту и ширину
        //с которой начальная картинка входит в новую
        $requiredWidth = $oldWidth * $ratioRequired;
        $requiredHeight = $oldHeight * $ratioRequired;
        
        //echo 'requiredWidth = ' . $requiredWidth . '<br />';
        //echo 'requiredHeight' . $requiredHeight . '<br />';
        
        //расчёт параметров отцентровки
        $shiftX = ($requiredWidth - $newWidth)/2;
        $shiftY = ($requiredHeight - $newHeight)/2;
        
        //echo 'shiftX = ' . $shiftX . '<br />';
        //echo 'shiftY = ' . $shiftY . '<br />';
        
        //создаём новую картинку с заданными параметрами
        $imageNew = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($imageNew, 255, 255, 255);
        imagefill($imageNew, 0, 0, $white);
        
        //в зависимости от миме-типа создаём изображение
        switch ($mimeType) {
            
            case 'image/jpg':
                $imageOld = imagecreatefromjpeg($image);
                break;
            
            case 'image/gif':
                $imageOld = imagecreatefromgif($image);
                break;
            
            case 'image/png':
                //Отключаем режим сопряжения цветов
                imagealphablending($imageNew, false);
                 //сохраняем альфаканал
                imagesavealpha($imageNew, true);
                
                $imageOld = imagecreatefrompng($image);
                break;

            default:
                return $image;
                break;
        }
        
        //вписываем исходное изображение в новое
        $result = imagecopyresampled($imageNew, $imageOld, -$shiftX, -$shiftY, 0, 0, $requiredWidth, $requiredHeight, $oldWidth, $oldHeight);
        
        return $imageNew;
        
    }
    
    
    /*
     * 15-12-2014
     * 
     * function resizeStandart
     * 
     * Действует нак уменьшение, 
     * но ещё и растягивая изображение
     * 
     * общими словами, деформирует изображения
     * до нужных размеров
     * 
     * roy
     */
    
    
    private function resizeStandart($image, $mimeType, $newWidth = 0, $newHeight = 0){
        list($oldWidth, $oldHeight) = getimagesize($image);
        
        //если новая ширина, меньше старой, то обрезать не нужно 
        if(!$newWidth && !$newHeight){
            return $image;
        }
        
        //если не задана высота, то расчитать
        if(!$newHeight){
            $ratio = $newWidth/$oldWidth;
            $newHeight = round($oldHeight * $ratio); 
        }
        
        //если не задана ширина, то расчитать
        if(!$newWidth){
            $ratio = $newHeight/$oldHeight;
            $newWidth = round($oldWidth * $ratio);
        }
        
        $imageNew = imagecreatetruecolor($newWidth, $newHeight);
        
        switch ($mimeType) {
            
            case 'image/jpg':
                $imageOld = imagecreatefromjpeg($image);
                $result = imagecopyresampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
                break;
            
            case 'image/gif':
                $imageOld = imagecreatefromgif($image);
                $result = imagecopyresampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
                break;
            
            case 'image/png':
                //Отключаем режим сопряжения цветов
                imagealphablending($imageNew, false);
                 //сохраняем альфаканал
                imagesavealpha($imageNew, true);
                
                $imageOld = imagecreatefrompng($image);
                $result = imagecopyresampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
                break;

            default:
                return $image;
                break;
        }
        
        return $imageNew;
        
    }
            
            
    
    
}
