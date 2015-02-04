<?php

/*
 * 17-10-2014
 * Модель работы с изображениями
 * Данная модель предоставляет функции для работы с загружаемыми на сайт изображениями
 * roy
 */

class image extends modelsClass{
    
    private function getError($text){
        return array('errors' => 'Ошибка загрузки изображения. ' . $text);
    }
    
    /*
     * 17-10-2014
     * Загрузка изображения
     * roy
     */

    public function uploadImage(){
        
        //если файлов не получено вернуть ошибку
        if(empty($_FILES)){
            return $this->getError();
        }
        
        //Оу, даже не представляю зачем мне потребовалась такая конструкция
        //на днях попробую избавиться от неё
        //12-12-2014 12:45
       
        //Эврика! данная шняга просто извлекает $key из массива
        //Только зачем так?. Но да ладно. Работает и ладно.
        //12-12-2014 15:58
        foreach ($_FILES as $key => $value) {
            $fName = $key;
            $fileArray = $value;
        }
        
        //проверка на то, что фаил действительно изображение
        $imageinfo = getimagesize($fileArray['tmp_name']);
        if(!$this->confirmImage($imageinfo['mime'])){
            return false;
        }
        
        //получаем имя файла без системного префикса
        $fileName = str_replace('field_inner_', '', $fName);
        
        //получаем фильтры и все опции для данного поля
        $sqlFilter = "SELECT * FROM `field` f
                        INNER JOIN `image_filter` imf ON imf.id_image_filter = f.image_filter
                        INNER JOIN `thumb_image_filter` tif ON tif.image_filter = imf.id_image_filter
                        INNER JOIN `medium_image_filter` mif ON mif.image_filter = imf.id_image_filter
                        INNER JOIN `full_image_filter` fif ON fif.image_filter = imf.id_image_filter
                        WHERE f.field_name = '{$fileName}'";
                        
        $imageFilter = $this->query($sqlFilter);
        $imageFilter = $imageFilter[0];
    
        //получаем функцию обрезки для thumb
        $sqlCropThumb = "SELECT `crop_type` FROM `crop_type` WHERE `id_crop_type` = '{$imageFilter['thumb_crop_type']}' LIMIT 1";
        $imageFilter['thumb_crop_type'] = $this->query($sqlCropThumb);
        
        //получаем функцию обрезки для medium
        $sqlCropMedium = "SELECT `crop_type` FROM `crop_type` WHERE `id_crop_type` = '{$imageFilter['medium_crop_type']}' LIMIT 1";
        $imageFilter['medium_crop_type'] = $this->query($sqlCropMedium);
        
        //получаем функцию обрезки для full
        $sqlCropFull = "SELECT `crop_type` FROM `crop_type` WHERE `id_crop_type` = '{$imageFilter['full_crop_type']}' LIMIT 1";
        $imageFilter['full_crop_type'] = $this->query($sqlCropFull);
        
        
        //создаём экземпляр класса работы с изображениями
        $imageClass = new imageClass();
        
        
        //Работа с изображением
        //временно в разработке
        
        $fileName = uniqid() . '_' . $fileArray['name'];

        $paramsImage = array(
            'file' => $fName,
            'fileName' => $fileName,
            'mimeType' => $imageinfo['mime'],
            'width' => $imageFilter['thumb_width'],
            'height' => $imageFilter['thumb_height'],
            'dir' => $imageFilter['thumb_dir'],
            'crop' => $imageFilter['thumb_crop_type']
        );

        $imageClass->uploadStandart($paramsImage);

        $paramsImage['width'] = $imageFilter['medium_width'];
        $paramsImage['height'] = $imageFilter['medium_height'];
        $paramsImage['dir'] = $imageFilter['medium_dir'];
        $paramsImage['crop'] = $imageFilter['medium_crop_type'];

        $imageClass->uploadStandart($paramsImage);

        $paramsImage['width'] = $imageFilter['full_width'];
        $paramsImage['height'] = $imageFilter['full_height'];
        $paramsImage['dir'] = $imageFilter['full_dir'];
        $paramsImage['crop'] = $imageFilter['full_crop_type'];

        $imageClass->uploadStandart($paramsImage);
        
        //конец
        
        
        return array('file_name' => $fileName);
        
    }
    
    
    /*
     * 18-10-2014
     * Удаление изображения
     * roy
     */
    
    public function deleteImage($params){
        $params = $this->validate($params, $rules = array(
            'required' => 'id, field',
            'string' => 'id, field'
            ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $sql = "DELETE FROM `field_inner_{$params['field']}` WHERE `id_field_{$params['field']}` = '{$params['id']}'";
        $result = $this->query($sql);
        
        return $result;
        
    }
    
    
    
    /*
     * 22-10-2014
     * Добавление одиночного изображения
     * Roy
     */
    
//    public function addOneImage(){
//        
//        if(empty($_FILES)){
//            return $this->getError();
//        }
//        
//        $imageClass = new imageClass();
//        $imageinfo = getimagesize($_FILES['image']['tmp_name']);
//        
//        $prefix = uniqid();
//        $fileName = $prefix . '_' . $_FILES['image']['name'];
//        $fName = 'image';
//        switch ($imageinfo['mime']) {
//            
//            case 'image/jpg':
//                $imageClass->uploadJpg($fName, 1920, 1080, 'slider', $fileName);
//                
//                break;
//            
//            case 'image/jpeg':
//                $imageClass->uploadJpg($fName, 1920, 1080, 'slider', $fileName);
//                
//                break;
//            
//            case 'image/png':
//                $imageClass->uploadPng($fName, 1920, 1080, 'slider', $fileName);
//                
//                break;
//            
//            case 'image/gif':
//                $imageClass->uploadGif($fName, 1920, 1080, 'slider', $fileName);
//                
//                break;
//
//            default:
//                return $this->getError('Неправильный формат файла');
//                break;
//            
//        }
//        
//        return array('file_name' => $fileName);
//        
//    }
    
    /*
     * 22-10-2014
     * Проверка на коректный ввод изображения
     * roy
     */
    
    private function confirmImage($mime){
        if($mime == 'image/jpg' || $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif'){
            return true;
        }
        return false;
        
    }
    
}