<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inputModel
 *
 * @author Рой
 */
class inputModel extends modelsClass{
    
    
    /*
     * 13-01-2015
     * Подтверждение того, что загружена картинка
     * roy
     */
    
    private function confirmImage($mime){
        if($mime == 'image/jpg' || $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif'){
            return true;
        }
        return false;
        
    }
    
    
    /*
     * 13-01-2015
     * Получить все настройки фильтра изображений для данного поля
     * roy
     */
    
    public function getImageFilter($fieldName){
        $sqlFilter = "SELECT * FROM `field` f
                        INNER JOIN `image_filter` imf ON imf.id_image_filter = f.image_filter
                        INNER JOIN `thumb_image_filter` tif ON tif.image_filter = imf.id_image_filter
                        INNER JOIN `medium_image_filter` mif ON mif.image_filter = imf.id_image_filter
                        INNER JOIN `full_image_filter` fif ON fif.image_filter = imf.id_image_filter
                        WHERE f.field_name = '{$fieldName}'";
                        
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
        
        return $imageFilter;
    }
    
    
    
    
    public function updateSingleImage($params, $idPage){
        
        $files = $_FILES['field_inner_' . $params['field_name']];

        $imageFilter = $this->getImageFilter($params['field_name']);
        
        $imageinfo = getimagesize($files['tmp_name']);
        if(!$this->confirmImage($imageinfo['mime'])){
            return false;
        }
        
        
        //создаём экземпляр класса работы с изображениями
        $imageClass = new imageClass();
        
        
        //Работа с изображением
        //временно в разработке
        
        $fileName = uniqid() . '_' . $files['name'];

        $paramsImage = array(
            'file' => 'field_inner_' . $params['field_name'],
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
        
        
        $sql2 = "SELECT * FROM `field_inner_{$params['field_name']}` WHERE `page_id_{$params['field_name']}` = '{$idPage}'";
        $condit = $this->query($sql2);
        
        if($condit){
            $sql = "UPDATE `field_inner_{$params['field_name']}`
                SET `field_content_{$params['field_name']}` = '{$fileName}'
                WHERE `page_id_{$params['field_name']}` = '{$idPage}'";
        }else{
            $sql = "INSERT `field_inner_{$params['field_name']}`
                    (`field_content_{$params['field_name']}`, `page_id_{$params['field_name']}`)
                    VALUES('{$fileName}', '{$idPage}')";
        }
        
                
        $result = $this->query($sql);
                
        return $result;
        
    }
    
    
}
